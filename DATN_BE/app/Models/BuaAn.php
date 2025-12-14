<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuaAn extends Model
{
    protected $table = 'bua_ans';

    protected $fillable = [
        'ten_bua_an',
        'mo_ta',
    ];

   
}
