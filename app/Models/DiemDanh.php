<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiemDanh extends Model
{
    protected $table = 'diem_danhs';

    protected $fillable = [
        'id_lop_hoc',
        'id_hoc_sinh',
        'ngay_diem_danh',
        'tinh_trang',
        'ghi_chu',
    ];

    const TINH_TRANG = [
        0 => 'Vắng mặt',
        1 => 'Có mặt',
    ];

    /**
     * Chuyển đổi trạng thái từ string (frontend) sang integer (database)
     */
    public static function convertTrangThaiToInt($trangThai)
    {
        if ($trangThai === 'co_mat') {
            return 1;
        }
        // Tất cả các trạng thái vắng (vang, vang_co_phep, vang_khong_phep) đều là 0
        return 0;
    }

    /**
     * Chuyển đổi trạng thái từ integer (database) sang string (frontend)
     */
    public static function convertTrangThaiToString($tinhTrang)
    {
        if ($tinhTrang == 1) {
            return 'co_mat';
        }
        // Mặc định là 'vang' nếu là 0
        return 'vang';
    }


}
