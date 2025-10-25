<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThucDon extends Model
{
    protected $table = 'thuc_dons';

    protected $fillable = [

        'ten_thuc_don',
        'ngay',
        'mo_ta',
    ];
}
