<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocTinNhanNhom extends Model
{
    protected $table = 'doc_tin_nhan_nhom';

    protected $fillable = [
        'tin_nhan_nhom_id',
        'loai_nguoi_doc',
        'nguoi_doc_id',
        'da_doc',
        'doc_luc',
    ];

    protected $casts = [
        'da_doc' => 'boolean',
        'doc_luc' => 'datetime',
    ];

    /**
     * Tin nhắn nhóm
     */
    public function tinNhanNhom()
    {
        return $this->belongsTo(TinNhanNhom::class);
    }

    /**
     * Người đọc (polymorphic relationship)
     */
    public function getNguoiDocAttribute()
    {
        if ($this->loai_nguoi_doc === 'giao_vien') {
            return GiaoVien::find($this->nguoi_doc_id);
        }
        return PhuHuynh::find($this->nguoi_doc_id);
    }
}
