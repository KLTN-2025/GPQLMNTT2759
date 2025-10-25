<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChiTietThucDon extends Model
{
    protected $table = 'chi_tiet_thuc_dons';

    protected $fillable = [
        'id_thuc_don',
        'id_mon_an',
        'id_bua_an',
        'so_luong',
        'ghi_chu',
    ];


}
