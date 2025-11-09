<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietHocPhi extends Model
{
    protected $table = 'chi_tiet_hoc_phis';

    protected $fillable = [
        'id_hoa_don_hoc_phi',
        'id_hoc_phi',
        'so_luong',
        'don_gia',
        'thanh_tien',
        'ghi_chu',
    ];
}
