<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinNhanNhom extends Model
{
    protected $table = 'tin_nhan_nhom';

    protected $fillable = [
        'nhom_chat_id',
        'loai_nguoi_gui',
        'nguoi_gui_id',
        'noi_dung',
    ];

    protected $appends = ['nguoi_gui'];

    /**
     * Nhóm chat
     */
    public function nhomChat()
    {
        return $this->belongsTo(NhomChatLop::class, 'nhom_chat_id');
    }

    /**
     * Người gửi (polymorphic relationship)
     */
    public function getNguoiGuiAttribute()
    {
        if ($this->loai_nguoi_gui === 'giao_vien') {
            return GiaoVien::find($this->nguoi_gui_id);
        }
        return PhuHuynh::find($this->nguoi_gui_id);
    }

    /**
     * Trạng thái đã đọc
     */
    public function docStatus()
    {
        return $this->hasMany(DocTinNhanNhom::class, 'tin_nhan_nhom_id');
    }

    /**
     * Check if read by specific user
     */
    public function isReadBy($loai, $userId)
    {
        return $this->docStatus()
            ->where('loai_nguoi_doc', $loai)
            ->where('nguoi_doc_id', $userId)
            ->where('da_doc', true)
            ->exists();
    }
}
