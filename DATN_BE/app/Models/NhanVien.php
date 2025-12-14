<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    public function chucVu(): BelongsTo
    {
        return $this->belongsTo(ChucVu::class, 'id_chuc_vu');
    }

    public function lopHoc(): HasMany
    {
        return $this->hasMany(LopHoc::class, 'id_giao_vien');
    }

    public function nhanXet(): HasMany
    {
        return $this->hasMany(NhanXet::class, 'id_giao_vien');
    }

    public function baiViet(): HasMany
    {
        return $this->hasMany(BaiViet::class, 'id_nhan_vien');
    }

    public function thongBao(): HasMany
    {
        return $this->hasMany(ThongBao::class, 'id_nhan_vien');
    }
}
