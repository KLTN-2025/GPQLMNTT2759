<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SucKhoe extends Model
{
    protected $table = 'suc_khoes';

    protected $fillable = [
        'id_hoc_sinh',
        'ngay_kham',
        'chieu_cao',
        'can_nang',
        'thi_luc',
        'rang_mieng',
        'tinh_trang_suc_khoe',
        'loai_kham',
        'ghi_chu',
    ];
}
