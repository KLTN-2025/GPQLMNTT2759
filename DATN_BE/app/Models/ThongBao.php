<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThongBao extends Model
{
    protected $table = 'thong_baos';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'tep_dinh_kem',
        'thoi_gian_dang',
        'ngay_het_hieu_luc',
        'tinh_trang',
        'id_nhan_vien',
        'loai_thong_bao',
    ];

    const LOAI_THONG_BAO = [
        'TOAN_TRUONG' => 0,
        'THEO_LOP' => 1,
        'CA_NHAN' => 2,
        'HE_THONG' => 3,
        'SU_KIEN' => 4,
        'KHAN_CAP' => 5,
    ];
    const TINH_TRANG = [
        'CHUA_GUI' => 0,
        'DA_GUI' => 1,
        'DA_HUY' => 2,
    ];
}
