<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BinhLuan extends Model
{
    protected $table = 'binh_luans';

    protected $fillable = [
        'id_bai_viet',
        'id_phu_huynh',
        'noi_dung',
        'ngay_binh_luan',
    ];


}
