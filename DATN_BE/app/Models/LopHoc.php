<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    use HasFactory;

    protected $table = 'lop_hocs';

    protected $fillable = [
        'ten_lop',
        'id_khoi_lop',
        'id_nam_hoc',
        'id_giao_vien',
        'so_luong',
        'is_block',
    ];
}
