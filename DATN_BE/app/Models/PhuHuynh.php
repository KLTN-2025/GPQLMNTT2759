<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuHuynh extends Model
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
}
