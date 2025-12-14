<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HocPhi extends Model
{
    protected $table = 'hoc_phis';

    protected $fillable = [
        'ten_loai_phi',
        'don_gia',
        'don_vi_tinh',
        'ap_dung_tu_ngay',
        'ap_dung_den_ngay',
        'mo_ta',
        'tinh_trang',
        
    ];

    const TINH_TRANG = [
        0 => 'Không hoạt động',
        1 => 'Hoạt động',
    ];


}
