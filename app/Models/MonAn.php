<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonAn extends Model
{
    protected $table = 'mon_ans';

    protected $fillable = [
        'ten_mon',
        'mo_ta',
        'ghi_chu',
        'hinh_anh',
        'loai_mon',
        'nguon_goc',
        'calo',
        'protein',
        'carb',
        'fat',
        'is_block',
    ];

    
}
