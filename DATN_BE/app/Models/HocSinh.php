<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocSinh extends Model
{
    protected $table = 'hoc_sinhs';

    protected $fillable = [
        'ho_va_ten',
        'gioi_tinh',
        'avatar',
        'ngay_sinh',
        'dia_chi',
        'tinh_trang',
        'id_lop_hoc',
        'id_phu_huynh',
        'is_block',
    ];

    const TINH_TRANG = [
        0 => 'Không hoạt động',
        1 => 'Hoạt động',
        2 => 'Vắng mặt',
    ];
}
