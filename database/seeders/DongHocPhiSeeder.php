<?php

namespace Database\Seeders;

use App\Models\DongHocPhi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DongHocPhiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('dong_hoc_phis')->delete();
        DB::table('dong_hoc_phis')->truncate();

        $dongHocPhis = [
            [
                'id' => 1,
                'id_hoc_sinh' => 1,
                'id_hoc_phi' => 1,
                'so_tien_dong' => 1500000,
                'ngay_dong' => '2025-01-05',
                'hinh_thuc_thanh_toan' => 'Tiền mặt',
                'ghi_chu' => 'Đóng học phí tháng 1/2025',
                'tinh_trang' => false,
            ],
            [
                'id' => 2,
                'id_hoc_sinh' => 2,
                'id_hoc_phi' => 1,
                'so_tien_dong' => 1500000,
                'ngay_dong' => '2025-01-06',
                'hinh_thuc_thanh_toan' => 'Chuyển khoản',
                'ghi_chu' => 'Đóng học phí tháng 1/2025',
                'tinh_trang' => true,
            ],
            [
                'id' => 3,
                'id_hoc_sinh' => 1,
                'id_hoc_phi' => 4,
                'so_tien_dong' => 800000,
                'ngay_dong' => '2025-01-05',
                'hinh_thuc_thanh_toan' => 'Tiền mặt',
                'ghi_chu' => 'Đóng phí ăn tháng 1/2025',
                'tinh_trang' => true,
            ],
            [
                'id' => 4,
                'id_hoc_sinh' => 2,
                'id_hoc_phi' => 4,
                'so_tien_dong' => 800000,
                'ngay_dong' => '2025-01-06',
                'hinh_thuc_thanh_toan' => 'Chuyển khoản',
                'ghi_chu' => 'Đóng phí ăn tháng 1/2025',
                'tinh_trang' => true,
            ],
        ];

        DB::table('dong_hoc_phis')->insert($dongHocPhis);
    }
}
