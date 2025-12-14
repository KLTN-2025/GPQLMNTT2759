<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NamHoc extends Model
{
    protected $table = 'nam_hocs';

    protected $fillable = [
        'ten_nam_hoc',
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];

    
}
