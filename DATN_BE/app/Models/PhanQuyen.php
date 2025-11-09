<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhanQuyen extends Model
{
    protected $table = 'phan_quyens';

    protected $fillable = [
        'id_chuc_vu',
        'id_chuc_nang',
    ];

    
}
