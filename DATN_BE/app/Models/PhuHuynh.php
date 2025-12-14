<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhuHuynh extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'phu_huynhs';

    protected $fillable = [
        'ho_va_ten',
        'so_dien_thoai',
        'avatar',
        'email',
        'dia_chi',
        'quan_he',
        'password',
        'gioi_tinh',
        'nghe_nghiep',
        'ngay_sinh',
        'is_block',
        'is_active',
        'hash_reset',
    ];

    const IS_BLOCK = [
        0 => 'Không khóa',
        1 => 'Khóa',
    ];
    
}
