<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietThongBao extends Model
{
    protected $table = 'chi_tiet_thong_baos';

    protected $fillable = [
        'id_thong_bao',
        'id_phu_huynh',
        'id_giao_vien',
        'id_lop_hoc',
    ];

    /**
     * Quan hệ với bảng ThongBao
     */
    public function thongBao(): BelongsTo
    {
        return $this->belongsTo(ThongBao::class, 'id_thong_bao');
    }

    /**
     * Quan hệ với bảng PhuHuynh
     */
    public function phuHuynh(): BelongsTo
    {
        return $this->belongsTo(PhuHuynh::class, 'id_phu_huynh');
    }

    /**
     * Quan hệ với bảng GiaoVien
     */
    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class, 'id_giao_vien');
    }

    /**
     * Quan hệ với bảng LopHoc
     */
    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(LopHoc::class, 'id_lop_hoc');
    }
}
