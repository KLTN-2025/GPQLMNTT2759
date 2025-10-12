<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NhanVien extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'nhan_viens';

    protected $fillable = [
        'ho_va_ten',
        'so_dien_thoai',
        'avatar',
        'email',
        'id_chuc_vu',
        'password',
        'gioi_tinh',
        'dia_chi',
        'ngay_sinh',
        'is_block',
        'tinh_trang',
        'hash_reset',
    ];
}
