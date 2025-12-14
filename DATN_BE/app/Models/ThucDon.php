<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThucDon extends Model
{
    protected $table = 'thuc_dons';

    protected $fillable = [
        'ten_thuc_don',
        'ngay',
        'mo_ta',
        'id_lop_hoc',
    ];

    /**
     * Relationship: Thực đơn có nhiều chi tiết thực đơn
     */
    public function chiTietThucDons(): HasMany
    {
        return $this->hasMany(\App\Models\ChiTietThucDon::class, 'id_thuc_don', 'id');
    }

    /**
     * Relationship: Thực đơn thuộc về lớp học
     */
    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(\App\Models\LopHoc::class, 'id_lop_hoc', 'id');
    }

    /**
     * Relationship: Lấy danh sách món ăn thông qua chi tiết thực đơn
     */
    public function monAns()
    {
        return $this->hasManyThrough(
            \App\Models\MonAn::class,
            \App\Models\ChiTietThucDon::class,
            'id_thuc_don', // Foreign key on chi_tiet_thuc_dons table
            'id',          // Foreign key on mon_ans table
            'id',          // Local key on thuc_dons table
            'id_mon_an'    // Local key on chi_tiet_thuc_dons table
        );
    }
}
