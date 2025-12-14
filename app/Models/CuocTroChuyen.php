<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuocTroChuyen extends Model
{
    protected $table = 'cuoc_tro_chuyen';

    protected $fillable = [
        'giao_vien_id',
        'phu_huynh_id',
        'tin_nhan_cuoi_id',
        'thoi_gian_cuoi',
    ];

    protected $casts = [
        'thoi_gian_cuoi' => 'datetime',
    ];

    // Relationships
    public function giaoVien(): BelongsTo
    {
        return $this->belongsTo(GiaoVien::class, 'giao_vien_id');
    }

    public function phuHuynh(): BelongsTo
    {
        return $this->belongsTo(PhuHuynh::class, 'phu_huynh_id');
    }

    public function tinNhans(): HasMany
    {
        return $this->hasMany(TinNhan::class, 'cuoc_tro_chuyen_id');
    }

    public function tinNhanCuoi(): BelongsTo
    {
        return $this->belongsTo(TinNhan::class, 'tin_nhan_cuoi_id');
    }

    // Scopes
    public function scopeForUser($query, $userType, $userId)
    {
        if ($userType === 'giao_vien') {
            return $query->where('giao_vien_id', $userId);
        }
        return $query->where('phu_huynh_id', $userId);
    }

    // Helper methods
    public function getUnreadCount($userType)
    {
        $oppositeType = $userType === 'giao_vien' ? 'phu_huynh' : 'giao_vien';

        return $this->tinNhans()
            ->where('loai_nguoi_gui', $oppositeType)
            ->where('da_doc', false)
            ->count();
    }

    public function markAsRead($userType)
    {
        $oppositeType = $userType === 'giao_vien' ? 'phu_huynh' : 'giao_vien';

        $this->tinNhans()
            ->where('loai_nguoi_gui', $oppositeType)
            ->where('da_doc', false)
            ->update(['da_doc' => true]);
    }
}
