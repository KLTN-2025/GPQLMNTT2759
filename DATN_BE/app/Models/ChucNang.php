<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChucNang extends Model
{
    protected $table = 'chuc_nangs';

    protected $fillable = [
        'ten_chuc_nang',
        'mo_ta',
    ];

    
}
