<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhanXet extends Model
{
    protected $table = 'nhan_xets';

    protected $fillable = [
        'id_hoc_sinh',
        'ngay_nhan_xet',
        'id_giao_vien',
        'noi_dung',
        'danh_gia',
    ];


}
