<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DongHocPhi extends Model
{
    protected $table = 'dong_hoc_phis';

    protected $fillable = [
        'id_hoc_phi',
        'id_hoc_sinh',
        'so_tien_dong',
        'ngay_dong',
        'hinh_thuc_thanh_toan',
        'ghi_chu',
        'tinh_trang',
    ];


}
