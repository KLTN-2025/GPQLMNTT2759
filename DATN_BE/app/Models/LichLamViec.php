<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichLamViec extends Model
{
    protected $table = 'lich_lam_viecs';

    protected $fillable = [
        'id_nhan_vien',
        'id_giao_vien',
        'ngay_lam_viec',
        'ca_lam_viec',
    ];
    const CA_LAM_VIEC = [
        1 => 'Ca sáng',
        2 => 'Ca chiều',
        3 => 'Ca tối',
    ];
}
