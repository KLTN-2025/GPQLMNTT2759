<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KhoiLop extends Model
{
    protected $table = 'khoi_lops';

    protected $fillable = [
        'ten_khoi_lop',
        'do_tuoi',
        'mo_ta',
        'so_luong_lop',
    ];

}
