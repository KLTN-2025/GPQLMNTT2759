<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiemDanh extends Model
{
    protected $table = 'diem_danhs';

    protected $fillable = [
        'id_lop_hoc',
        'id_hoc_sinh',
        'ngay_diem_danh',
        'tinh_trang',
        'ghi_chu',
    ];

}
