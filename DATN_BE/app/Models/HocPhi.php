<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HocPhi extends Model
{
    protected $table = 'hoc_phis';

    protected $fillable = [
        'ten_hoc_phi',
        'so_tien',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'mo_ta',
    ];


}
