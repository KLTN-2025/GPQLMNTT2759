<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChucVu extends Model
{
    protected $table = 'chuc_vus';

    protected $fillable = [
        'ten_chuc_vu',
        'slug_chuc_vu',
        'tinh_trang',
        'mo_ta',
        'loai_chuc_vu',
    ];
}
