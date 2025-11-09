<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDonHocPhi extends Model
{
    protected $table = 'hoa_don_hoc_phis';

    protected $fillable = [
        'id_hoc_sinh',
        'id_lop',
        'hoc_phi_thang_nam',
        'tong_tien',
        'da_thanh_toan',
        'con_no',
        'tinh_trang',
        'ngay_tao',
        'ngay_thanh_toan',
        'id_nhan_vien',
    ];

    const TINH_TRANG = [
        0 => 'Chưa thanh toán',
        1 => 'Đã thanh toán',
    ];
}
