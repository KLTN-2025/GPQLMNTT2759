<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HocSinh extends Model
{
    use HasFactory;

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
