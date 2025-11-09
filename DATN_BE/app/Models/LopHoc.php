<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LopHoc extends Model
{
    use HasFactory;

    protected $table = 'lop_hocs';

    protected $fillable = [
        'ten_lop',
        'id_khoi_lop',
        'id_nam_hoc',
        'id_giao_vien',
        'so_luong',
        'is_block',
    ];

    
}
