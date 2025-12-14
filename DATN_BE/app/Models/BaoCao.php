<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaoCao extends Model
{
    protected $table = 'bao_caos';

    protected $fillable = [
        'id_giao_vien',
        'id_nhan_vien',
        'loai_bao_cao',
        'tieu_de',
        'duong_dan',
        'ngay_tao',
        'ngay_ky',
        'tinh_trang',
    ];
}
