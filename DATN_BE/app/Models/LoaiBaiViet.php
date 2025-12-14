<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoaiBaiViet extends Model
{
    protected $table = 'loai_bai_viets';

    protected $fillable = [
        'ten_loai',
        'mo_ta',
        'tinh_trang',
    ];


}
