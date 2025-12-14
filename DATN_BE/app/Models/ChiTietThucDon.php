<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietThucDon extends Model
{
    protected $table = 'chi_tiet_thuc_dons';

    protected $fillable = [
        'id_thuc_don',
        'id_mon_an',
        'id_bua_an',
        'so_luong',
        'ghi_chu',
    ];

    /**
     * Relationship: Chi tiết thực đơn thuộc về thực đơn
     */
    public function thucDon(): BelongsTo
    {
        return $this->belongsTo(\App\Models\ThucDon::class, 'id_thuc_don', 'id');
    }

    /**
     * Relationship: Chi tiết thực đơn thuộc về món ăn
     */
    public function monAn(): BelongsTo
    {
        return $this->belongsTo(\App\Models\MonAn::class, 'id_mon_an', 'id');
    }

    /**
     * Relationship: Chi tiết thực đơn thuộc về bữa ăn
     */
    public function buaAn(): BelongsTo
    {
        return $this->belongsTo(\App\Models\BuaAn::class, 'id_bua_an', 'id');
    }
}
