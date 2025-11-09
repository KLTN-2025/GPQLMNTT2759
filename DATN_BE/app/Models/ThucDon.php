<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThucDon extends Model
{
    protected $table = 'thuc_dons';

    protected $fillable = [

        'ten_thuc_don',
        'ngay',
        'mo_ta',
    ];
}
