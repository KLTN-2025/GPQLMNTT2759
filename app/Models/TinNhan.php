<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TinNhan extends Model
{
    protected $table = 'tin_nhans';

    protected $fillable = [
        'cuoc_tro_chuyen_id',
        'loai_nguoi_gui',
        'nguoi_gui_id',
        'noi_dung',
        'da_doc',
        'file_dinh_kem',
    ];

    protected $casts = [
        'da_doc' => 'boolean',
        'created_at' => 'datetime',
    ];

    protected $appends = ['thoi_gian_gui'];

    // Relationships
    public function cuocTroChuyen(): BelongsTo
    {
        return $this->belongsTo(CuocTroChuyen::class, 'cuoc_tro_chuyen_id');
    }

    public function nguoiGui()
    {
        if ($this->loai_nguoi_gui === 'giao_vien') {
            return $this->belongsTo(GiaoVien::class, 'nguoi_gui_id');
        }
        return $this->belongsTo(PhuHuynh::class, 'nguoi_gui_id');
    }

    // Accessors
    public function getThoiGianGuiAttribute()
    {
        if (!$this->created_at) {
            return null;
        }

        $now = Carbon::now();
        $diff = $this->created_at->diffInMinutes($now);

        if ($diff < 1) {
            return 'Vừa xong';
        } elseif ($diff < 60) {
            return $diff . ' phút trước';
        } elseif ($diff < 1440) { // 24 hours
            return $this->created_at->diffInHours($now) . ' giờ trước';
        } else {
            return $this->created_at->format('d/m/Y H:i');
        }
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('da_doc', false);
    }

    public function scopeInConversation($query, $conversationId)
    {
        return $query->where('cuoc_tro_chuyen_id', $conversationId)
            ->orderBy('created_at', 'asc');
    }
}
