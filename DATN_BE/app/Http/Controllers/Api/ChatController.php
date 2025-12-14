<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CuocTroChuyen;
use App\Models\TinNhan;
use App\Models\GiaoVien;
use App\Models\PhuHuynh;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Get all conversations for authenticated user
     */
    public function getConversations(Request $request)
    {
        try {
            $user = $request->user();
            $userType = $user instanceof GiaoVien ? 'giao_vien' : 'phu_huynh';

            $conversations = CuocTroChuyen::forUser($userType, $user->id)
                ->with(['giaoVien', 'phuHuynh', 'tinNhanCuoi'])
                ->orderBy('thoi_gian_cuoi', 'desc')
                ->get()
                ->map(function ($conversation) use ($userType, $user) {
                    $partner = $userType === 'giao_vien'
                        ? $conversation->phuHuynh
                        : $conversation->giaoVien;

                    return [
                        'id' => $conversation->id,
                        'partner_id' => $partner->id,
                        'partner_name' => $partner->ho_va_ten,
                        'partner_avatar' => $partner->avatar ?? '/default-avatar.png',
                        'last_message' => $conversation->tinNhanCuoi?->noi_dung ?? '',
                        'last_time' => $conversation->thoi_gian_cuoi?->format('H:i d/m/Y') ?? '',
                        'unread_count' => $conversation->getUnreadCount($userType),
                        'online' => false, // TODO: implement online status
                    ];
                });

            return response()->json([
                'status' => true,
                'data' => $conversations,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi khi tải danh sách cuộc trò chuyện: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get messages in a conversation (with pagination)
     */
    public function getMessages(Request $request, $conversationId)
    {
        try {
            $user = $request->user();
            $userType = $user instanceof GiaoVien ? 'giao_vien' : 'phu_huynh';

            $conversation = CuocTroChuyen::findOrFail($conversationId);

            // Verify user is part of this conversation
            if ($userType === 'giao_vien' && $conversation->giao_vien_id !== $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
            if ($userType === 'phu_huynh' && $conversation->phu_huynh_id !== $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }

            // Get messages with pagination
            $messages = TinNhan::inConversation($conversationId)
                ->orderBy('thoi_gian_gui', 'desc')
                ->paginate(50);

            $formattedMessages = $messages->getCollection()->map(function ($message) use ($userType) {
                return [
                    'id' => $message->id,
                    'sender' => $message->loai_nguoi_gui === $userType ? 'me' : 'them',
                    'sender_type' => $message->loai_nguoi_gui,
                    'sender_id' => $message->nguoi_gui_id,
                    'text' => $message->noi_dung,
                    'time' => $message->thoi_gian_gui->toISOString(),
                    'is_read' => $message->da_doc,
                    'file' => $message->file_dinh_kem,
                ];
            });

            return response()->json([
                'status' => true,
                'data' => [
                    'messages' => $formattedMessages,
                    'pagination' => [
                        'current_page' => $messages->currentPage(),
                        'last_page' => $messages->lastPage(),
                        'per_page' => $messages->perPage(),
                        'total' => $messages->total(),
                    ]
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi khi tải tin nhắn: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:cuoc_tro_chuyen,id',
            'noi_dung' => 'required|string|max:5000',
            'file_dinh_kem' => 'nullable|file|max:10240', // 10MB max
        ]);

        try {
            $user = $request->user();
            $userType = $user instanceof GiaoVien ? 'giao_vien' : 'phu_huynh';

            $conversation = CuocTroChuyen::findOrFail($request->conversation_id);

            // Verify user is part of this conversation
            if ($userType === 'giao_vien' && $conversation->giao_vien_id !== $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
            if ($userType === 'phu_huynh' && $conversation->phu_huynh_id !== $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }

            DB::beginTransaction();

            // Handle file upload if present
            $filePath = null;
            if ($request->hasFile('file_dinh_kem')) {
                $file = $request->file('file_dinh_kem');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('chat-files', $fileName, 'public');
            }

            // Create message
            $message = TinNhan::create([
                'cuoc_tro_chuyen_id' => $conversation->id,
                'loai_nguoi_gui' => $userType,
                'nguoi_gui_id' => $user->id,
                'noi_dung' => $request->noi_dung,
                'file_dinh_kem' => $filePath,
            ]);

            // Update conversation
            $conversation->update([
                'tin_nhan_cuoi_id' => $message->id,
                'thoi_gian_cuoi' => now(),
            ]);

            DB::commit();

            // Broadcast event
            broadcast(new MessageSent($message, $conversation))->toOthers();

            return response()->json([
                'status' => true,
                'message' => 'Tin nhắn đã được gửi',
                'data' => [
                    'id' => $message->id,
                    'sender' => 'me',
                    'sender_type' => $userType,
                    'sender_id' => $user->id,
                    'text' => $message->noi_dung,
                    'time' => $message->thoi_gian_gui->toISOString(),
                    'file' => $message->file_dinh_kem,
                    'is_read' => false,
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Lỗi khi gửi tin nhắn: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark conversation as read
     */
    public function markAsRead(Request $request, $conversationId)
    {
        try {
            $user = $request->user();
            $userType = $user instanceof GiaoVien ? 'giao_vien' : 'phu_huynh';

            $conversation = CuocTroChuyen::findOrFail($conversationId);

            // Verify user is part of this conversation
            if ($userType === 'giao_vien' && $conversation->giao_vien_id !== $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }
            if ($userType === 'phu_huynh' && $conversation->phu_huynh_id !== $user->id) {
                return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
            }

            $conversation->markAsRead($userType);

            return response()->json([
                'status' => true,
                'message' => 'Đã đánh dấu đã đọc',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get or create conversation with a user
     */
    public function getOrCreateConversation(Request $request, $partnerId)
    {
        try {
            $user = $request->user();
            $userType = $user instanceof GiaoVien ? 'giao_vien' : 'phu_huynh';

            if ($userType === 'giao_vien') {
                // Teacher creating conversation with parent
                $partner = PhuHuynh::findOrFail($partnerId);
                $conversation = CuocTroChuyen::firstOrCreate([
                    'giao_vien_id' => $user->id,
                    'phu_huynh_id' => $partnerId,
                ]);
            } else {
                // Parent creating conversation with teacher
                $partner = GiaoVien::findOrFail($partnerId);
                $conversation = CuocTroChuyen::firstOrCreate([
                    'giao_vien_id' => $partnerId,
                    'phu_huynh_id' => $user->id,
                ]);
            }

            // Load relationships for return data
            $conversation->load(['giaoVien', 'phuHuynh', 'tinNhanCuoi']);

            return response()->json([
                'status' => true,
                'message' => 'Cuộc trò chuyện đã sẵn sàng',
                'data' => [
                    'conversation_id' => $conversation->id,
                    'partner_id' => $partner->id,
                    'partner_name' => $partner->ho_va_ten,
                    'partner_avatar' => $partner->avatar ?? '/default-avatar.png',
                    'last_message' => $conversation->tinNhanCuoi?->noi_dung ?? '',
                    'last_time' => $conversation->thoi_gian_cuoi?->toISOString() ?? now()->toISOString(),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
