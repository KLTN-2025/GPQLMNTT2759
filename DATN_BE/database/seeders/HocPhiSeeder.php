<?php

namespace Database\Seeders;

use App\Models\HocPhi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HocPhiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('hoc_phis')->delete();
        DB::table('hoc_phis')->truncate();

        $hocPhis = [
            [
                'id' => 1,
                'ten_loai_phi' => 'Học phí mầm non',
                'don_gia' => 800000.00,  // Giảm từ 1.500.000
                'don_vi_tinh' => 'Tháng',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Học phí cơ bản cho học sinh mầm non',
                'tinh_trang' => 1,
            ],
            [
                'id' => 2,
                'ten_loai_phi' => 'Phí ăn sáng',
                'don_gia' => 150000.00,  // Giảm từ 300.000
                'don_vi_tinh' => 'Tháng',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí ăn sáng cho học sinh',
                'tinh_trang' => 1,
            ],
            [
                'id' => 3,
                'ten_loai_phi' => 'Phí ăn trưa',
                'don_gia' => 250000.00,  // Giảm từ 500.000
                'don_vi_tinh' => 'Tháng',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí ăn trưa cho học sinh',
                'tinh_trang' => 1,
            ],
            [
                'id' => 4,
                'ten_loai_phi' => 'Phí bán trú',
                'don_gia' => 100000.00,  // Giảm từ 200.000
                'don_vi_tinh' => 'Tháng',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí bán trú cho học sinh',
                'tinh_trang' => 1,
            ],
            [
                'id' => 5,
                'ten_loai_phi' => 'Phí đồ dùng học tập',
                'don_gia' => 80000.00,   // Giảm từ 150.000
                'don_vi_tinh' => 'Năm',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí đồ dùng học tập cho cả năm học',
                'tinh_trang' => 1,
            ],
            [
                'id' => 6,
                'ten_loai_phi' => 'Phí đồng phục',
                'don_gia' => 150000.00,  // Giảm từ 300.000
                'don_vi_tinh' => 'Bộ',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí đồng phục cho học sinh',
                'tinh_trang' => 1,
            ],
            [
                'id' => 7,
                'ten_loai_phi' => 'Phí ngoại khóa',
                'don_gia' => 50000.00,   // Giảm từ 100.000
                'don_vi_tinh' => 'Tháng',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí hoạt động ngoại khóa',
                'tinh_trang' => 1,
            ],
            [
                'id' => 8,
                'ten_loai_phi' => 'Phí y tế',
                'don_gia' => 30000.00,   // Giảm từ 50.000
                'don_vi_tinh' => 'Tháng',
                'ap_dung_tu_ngay' => '2025-01-01',
                'ap_dung_den_ngay' => '2025-12-31',
                'mo_ta' => 'Phí chăm sóc y tế cho học sinh',
                'tinh_trang' => 1,
            ],
        ];

        DB::table('hoc_phis')->insert($hocPhis);
    }
}
