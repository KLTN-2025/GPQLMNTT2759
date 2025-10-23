<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $table = 'bai_viets';

    protected $fillable = [
        'tieu_de',
        'slug_tieu_de',
        'noi_dung',
        'hinh_anh',
        'ngay_dang',
        'luot_xem',
        'tinh_trang',
        'id_nhan_vien',
        'id_loai_bai_viet',
    ];
}
