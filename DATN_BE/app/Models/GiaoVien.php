<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class GiaoVien extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'giao_viens';

    protected $fillable = [
        'ho_va_ten',
        'so_dien_thoai',
        'avatar',
        'email',
        'password',
        'gioi_tinh',
        'trinh_do',
        'chuyen_mon',
        'dia_chi',
        'ngay_sinh',
        'is_block',
        'id_chuc_vu',
        'tinh_trang',
        'hash_reset',
    ];
    const TRINH_DO = [
        0 => 'Trung cấp',
        1 => 'Cao đẳng',
        2 => 'Đại học',
        3 => 'Thạc sĩ',
        4 => 'Tiến sĩ',
        5 => 'Phó giáo sư',
        6 => 'Giáo sư',
        7 => 'Nhà giáo nhân dụng',
        8 => 'Nhà giáo ưu tú',
        9 => 'Nhà giáo đạt giải thưởng',
        10 => 'Nhà giáo đạt giải thưởng',
    ];
    const GIOI_TINH = [
        0 => 'Nữ',
        1 => 'Nam',
    ];
    const TINH_TRANG = [
        1 => 'Hoạt động',
        0 => 'Không hoạt động',
    ];
}
