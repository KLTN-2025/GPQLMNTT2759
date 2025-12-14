<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NhomChatLop;
use App\Models\TinNhanNhom;
use App\Models\DocTinNhanNhom;
use App\Models\LopHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\GroupMessageSent;

class GroupChatController extends Controller
{
    /**
     * Get group chat for teacher's class (auto-create if not exists)
     * GET /api/teacher/group-chat/my-class
     */
    public function getMyClassGroupChat()
    {
        $teacher = Auth::guard('sanctum')->user();

        if (!$teacher) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $lop = LopHoc::where('id_giao_vien', $teacher->id)->first();

        if (!$lop) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!'
            ], 404);
        }

        // Auto-create group chat if not exists
        $group = NhomChatLop::firstOrCreate(
            ['lop_hoc_id' => $lop->id],
            ['ten_nhom' => "{$lop->ten_lop} - Chat nhóm"]
        );

        $group->load('lopHoc');

        return response()->json([
            'status' => true,
            'message' => 'Lấy nhóm chat thành công',
            'data' => $group
        ]);
    }

    /**
     * Get all group chats for parent's children classes
     * GET /api/phu-huynh/group-chat/my-classes
     */
    public function getMyClassesForParent()
    {
        $parent = Auth::guard('sanctum')->user();

        if (!$parent) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Get all children's classes through hoc_sinhs table
        $lopHocIds = \DB::table('hoc_sinhs')
            ->where('phu_huynh_id', $parent->id)
            ->pluck('lop_hoc_id')
            ->unique();

        if ($lopHocIds->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Chưa có lớp học nào',
                'data' => []
            ]);
        }

        // Get or create group chats for all classes
        $groups = [];
        foreach ($lopHocIds as $lopId) {
            $lop = LopHoc::find($lopId);
            if ($lop) {
                $group = NhomChatLop::firstOrCreate(
                    ['lop_hoc_id' => $lopId],
                    ['ten_nhom' => "{$lop->ten_lop} - Chat nhóm"]
                );
                $group->load('lopHoc');
                $groups[] = $group;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách nhóm chat thành công',
            'data' => $groups
        ]);
    }

    /**
     * Get messages for a group chat
     * GET /api/teacher/group-chat/{groupId}/messages OR /api/phu-huynh/group-chat/{groupId}/messages
     */
    public function getMessages(Request $request, $groupId)
    {
        $user = Auth::guard('sanctum')->user();
        
        $group = NhomChatLop::find($groupId);
        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Nhóm không tồn tại'
            ], 404);
        }

        // Check permission based on user type
        $hasAccess = false;
        
        // If teacher, check if they own the class
        if ($user->getMorphClass() === 'App\\Models\\GiaoVien') {
            $hasAccess = $group->lopHoc->id_giao_vien === $user->id;
        } 
        // If parent, check if they have children in this class
        else if ($user->getMorphClass() === 'App\\Models\\PhuHuynh') {
            $hasAccess = DB::table('hoc_sinhs')
                ->where('phu_huynh_id', $user->id)
                ->where('lop_hoc_id', $group->lop_hoc_id)
                ->exists();
        }

        if (!$hasAccess) {
            return response()->json([
                'status' => false,
                'message' => 'Không có quyền truy cập nhóm này'
            ], 403);
        }

        $messages = TinNhanNhom::where('nhom_chat_id', $groupId)
            ->with('docStatus')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Append nguoi_gui info
        $messages->getCollection()->transform(function ($message) {
            $message->nguoi_gui_info = $message->nguoi_gui;
            return $message;
        });

        return response()->json([
            'status' => true,
            'data' => $messages
        ]);
    }

    /**
     * Send message to group chat
     * POST /api/teacher/group-chat/{groupId}/send OR /api/phu-huynh/group-chat/{groupId}/send
     */
    public function sendMessage(Request $request, $groupId)
    {
        $request->validate([
            'noi_dung' => 'required|string|max:5000'
        ]);

        $user = Auth::guard('sanctum')->user();

        $group = NhomChatLop::find($groupId);
        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Nhóm không tồn tại'
            ], 404);
        }

        // Check permission and determine sender type
        $hasAccess = false;
        $loaiNguoiGui = null;
        
        if ($user->getMorphClass() === 'App\\Models\\GiaoVien') {
            $hasAccess = $group->lopHoc->id_giao_vien === $user->id;
            $loaiNguoiGui = 'giao_vien';
        } 
        else if ($user->getMorphClass() === 'App\\Models\\PhuHuynh') {
            $hasAccess = DB::table('hoc_sinhs')
                ->where('phu_huynh_id', $user->id)
                ->where('lop_hoc_id', $group->lop_hoc_id)
                ->exists();
            $loaiNguoiGui = 'phu_huynh';
        }

        if (!$hasAccess) {
            return response()->json([
                'status' => false,
                'message' => 'Không có quyền gửi tin nhắn'
            ], 403);
        }

        $message = TinNhanNhom::create([
            'nhom_chat_id' => $groupId,
            'loai_nguoi_gui' => $loaiNguoiGui,
            'nguoi_gui_id' => $user->id,
            'noi_dung' => $request->noi_dung
        ]);

        $message->nguoi_gui_info = $message->nguoi_gui;

        // Broadcast event
        broadcast(new GroupMessageSent($message))->toOthers();

        return response()->json([
            'status' => true,
            'message' => 'Gửi tin nhắn thành công',
            'data' => $message
        ], 201);
    }

    /**
     * Mark messages as read for teacher
     * POST /api/teacher/group-chat/{groupId}/mark-read
     */
    public function markAsRead(Request $request, $groupId)
    {
        $teacher = Auth::guard('sanctum')->user();

        // Verify teacher owns this group
        $group = NhomChatLop::find($groupId);
        if (!$group || $group->lopHoc->id_giao_vien !== $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Không có quyền truy cập'
            ], 403);
        }

        // Get all unread messages from parents
        $unreadMessages = TinNhanNhom::where('nhom_chat_id', $groupId)
            ->where('loai_nguoi_gui', 'phu_huynh')
            ->get();

        foreach ($unreadMessages as $message) {
            DocTinNhanNhom::updateOrCreate(
                [
                    'tin_nhan_nhom_id' => $message->id,
                    'loai_nguoi_doc' => 'giao_vien',
                    'nguoi_doc_id' => $teacher->id
                ],
                [
                    'da_doc' => true,
                    'doc_luc' => now()
                ]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Đã đánh dấu đọc'
        ]);
    }

    /**
     * Get unread count for teacher
     * GET /api/teacher/group-chat/{groupId}/unread-count
     */
    public function getUnreadCount($groupId)
    {
        $teacher = Auth::guard('sanctum')->user();

        // Verify teacher owns this group
        $group = NhomChatLop::find($groupId);
        if (!$group || $group->lopHoc->id_giao_vien !== $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Không có quyền truy cập'
            ], 403);
        }

        // Count messages from parents that teacher hasn't read
        $count = TinNhanNhom::where('nhom_chat_id', $groupId)
            ->where('loai_nguoi_gui', 'phu_huynh')
            ->whereDoesntHave('docStatus', function ($query) use ($teacher) {
                $query->where('loai_nguoi_doc', 'giao_vien')
                    ->where('nguoi_doc_id', $teacher->id)
                    ->where('da_doc', true);
            })
            ->count();

        return response()->json([
            'status' => true,
            'data' => ['count' => $count]
        ]);
    }

    /**
     * Get participants (teacher + parents)
     * GET /api/teacher/group-chat/{groupId}/participants
     */
    public function getParticipants($groupId)
    {
        $teacher = Auth::guard('sanctum')->user();

        $group = NhomChatLop::with('lopHoc')->find($groupId);
        if (!$group || $group->lopHoc->id_giao_vien !== $teacher->id) {
            return response()->json([
                'status' => false,
                'message' => 'Không có quyền truy cập'
            ], 403);
        }

        $participants = $group->getParticipants();

        return response()->json([
            'status' => true,
            'data' => $participants
        ]);
    }
}
