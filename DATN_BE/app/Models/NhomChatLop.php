<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhomChatLop extends Model
{
    protected $table = 'nhom_chat_lop';

    protected $fillable = [
        'lop_hoc_id',
        'ten_nhom',
    ];

    /**
     * Lớp học
     */
    public function lopHoc()
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id');
    }

    /**
     * Tin nhắn trong nhóm
     */
    public function tinNhans()
    {
        return $this->hasMany(TinNhanNhom::class, 'nhom_chat_id');
    }

    /**
     * Lấy tin nhắn mới nhất
     */
    public function tinNhanMoiNhat()
    {
        return $this->hasOne(TinNhanNhom::class, 'nhom_chat_id')->latestOfMany();
    }

    /**
     * Get all participants (teacher + parents)
     */
    public function getParticipants()
    {
        $lop = $this->lopHoc;
        if (!$lop)
            return collect();

        $teacher = $lop->giaoVien;
        $parents = $lop->hocSinhs()
            ->with('phuHuynh')
            ->whereNotNull('id_phu_huynh')
            ->get()
            ->pluck('phuHuynh')
            ->filter()
            ->unique('id');

        return [
            'teacher' => $teacher,
            'parents' => $parents
        ];
    }
}
