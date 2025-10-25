<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SucKhoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('suc_khoes')->delete();
        DB::table('suc_khoes')->truncate();

        $sucKhoes = [
            // Học sinh 1 - Khám sức khỏe định kỳ
            [
                'id' => 1,
                'id_hoc_sinh' => 1,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 95.5,
                'can_nang' => 14.2,
                'ghi_chu' => 'Học sinh phát triển bình thường, chiều cao và cân nặng đạt chuẩn độ tuổi',
            ],
            [
                'id' => 2,
                'id_hoc_sinh' => 1,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 96.0,
                'can_nang' => 14.5,
                'ghi_chu' => 'Tăng trưởng ổn định, cần duy trì chế độ dinh dưỡng hiện tại',
            ],
            // Học sinh 2 - Khám sức khỏe định kỳ
            [
                'id' => 3,
                'id_hoc_sinh' => 2,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 98.2,
                'can_nang' => 15.8,
                'ghi_chu' => 'Phát triển tốt, chiều cao vượt trội so với độ tuổi',
            ],
            [
                'id' => 4,
                'id_hoc_sinh' => 2,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 98.8,
                'can_nang' => 16.0,
                'ghi_chu' => 'Tăng trưởng đều đặn, sức khỏe ổn định',
            ],
            // Học sinh 3 - Khám sức khỏe định kỳ
            [
                'id' => 5,
                'id_hoc_sinh' => 3,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Bình thường',
                'chieu_cao' => 92.5,
                'can_nang' => 13.5,
                'ghi_chu' => 'Phát triển bình thường, cần tăng cường dinh dưỡng',
            ],
            [
                'id' => 6,
                'id_hoc_sinh' => 3,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 93.2,
                'can_nang' => 13.8,
                'ghi_chu' => 'Cải thiện tốt, đã tăng cân và chiều cao',
            ],
            // Học sinh 4 - Khám sức khỏe định kỳ
            [
                'id' => 7,
                'id_hoc_sinh' => 4,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 105.5,
                'can_nang' => 18.2,
                'ghi_chu' => 'Phát triển tốt, đạt chuẩn độ tuổi 4-5 tuổi',
            ],
            [
                'id' => 8,
                'id_hoc_sinh' => 4,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 106.0,
                'can_nang' => 18.5,
                'ghi_chu' => 'Tăng trưởng ổn định, sức khỏe tốt',
            ],
            // Học sinh 5 - Khám sức khỏe định kỳ
            [
                'id' => 9,
                'id_hoc_sinh' => 5,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Bình thường',
                'chieu_cao' => 103.8,
                'can_nang' => 17.5,
                'ghi_chu' => 'Phát triển bình thường, cần chú ý chế độ ăn',
            ],
            [
                'id' => 10,
                'id_hoc_sinh' => 5,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 104.2,
                'can_nang' => 17.8,
                'ghi_chu' => 'Cải thiện tốt, đã điều chỉnh chế độ dinh dưỡng',
            ],
            // Học sinh 6 - Khám sức khỏe định kỳ
            [
                'id' => 11,
                'id_hoc_sinh' => 6,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 107.2,
                'can_nang' => 19.0,
                'ghi_chu' => 'Phát triển tốt, chiều cao và cân nặng đạt chuẩn',
            ],
            [
                'id' => 12,
                'id_hoc_sinh' => 6,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 107.8,
                'can_nang' => 19.2,
                'ghi_chu' => 'Tăng trưởng đều đặn, sức khỏe ổn định',
            ],
            // Học sinh 7 - Khám sức khỏe định kỳ
            [
                'id' => 13,
                'id_hoc_sinh' => 7,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 112.5,
                'can_nang' => 21.5,
                'ghi_chu' => 'Phát triển tốt, đạt chuẩn độ tuổi 5-6 tuổi',
            ],
            [
                'id' => 14,
                'id_hoc_sinh' => 7,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 113.0,
                'can_nang' => 21.8,
                'ghi_chu' => 'Tăng trưởng ổn định, sức khỏe tốt',
            ],
            // Học sinh 8 - Khám sức khỏe định kỳ
            [
                'id' => 15,
                'id_hoc_sinh' => 8,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Bình thường',
                'chieu_cao' => 110.8,
                'can_nang' => 20.5,
                'ghi_chu' => 'Phát triển bình thường, cần tăng cường vận động',
            ],
            [
                'id' => 16,
                'id_hoc_sinh' => 8,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 111.2,
                'can_nang' => 20.8,
                'ghi_chu' => 'Cải thiện tốt, đã tăng cường hoạt động thể chất',
            ],
            // Học sinh 9 - Khám sức khỏe định kỳ
            [
                'id' => 17,
                'id_hoc_sinh' => 9,
                'ngay_kham' => '2025-01-06',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 115.2,
                'can_nang' => 22.5,
                'ghi_chu' => 'Phát triển tốt, chiều cao và cân nặng đạt chuẩn',
            ],
            [
                'id' => 18,
                'id_hoc_sinh' => 9,
                'ngay_kham' => '2025-01-15',
                'tinh_trang' => 'Tốt',
                'chieu_cao' => 115.8,
                'can_nang' => 22.8,
                'ghi_chu' => 'Tăng trưởng đều đặn, sức khỏe ổn định',
            ],
        ];

        DB::table('suc_khoes')->insert($sucKhoes);
    }
}
