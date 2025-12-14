<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucKhoe extends Model
{
    protected $table = 'suc_khoes';

    protected $fillable = [
        'id_hoc_sinh',
        'ngay_kham',
        'chieu_cao',
        'can_nang',
        'thi_luc',
        'rang_mieng',
        'tinh_trang_suc_khoe',
        'loai_kham',
        'ghi_chu',
    ];

    const THI_LUC = [
        1 => 'Tốt',
        2 => 'Khá',
        3 => 'Trung bình',
        4 => 'Yếu',
    ];
    const RANG_MIENG = [
        1 => 'Tốt',
        2 => 'Khá',
        3 => 'Trung bình',
        4 => 'Yếu',
    ];
    const TINH_TRANG_SUC_KHOE = [
        0 => 'Nguy hiểm',
        1 => 'Cần can thiệp',
        2 => 'Cần theo dõi',
        3 => 'Tốt',
    ];
    const LOAI_KHAM = [
        1 => 'Định kì',
        0 => 'Cấp cứu',
    ];
}
