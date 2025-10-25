<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucKhoe extends Model
{
    protected $table = 'suc_khoes';

    protected $fillable = [
        'id_hoc_sinh',
        'ngay_kham',
        'tinh_trang',
        'chieu_cao',
        'can_nang',
        'ghi_chu',
    ];
}
