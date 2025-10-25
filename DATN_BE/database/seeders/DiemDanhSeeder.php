<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiemDanhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('diem_danhs')->delete();
        DB::table('diem_danhs')->truncate();

        $diemDanhs = [
            // Lớp Mầm - Ngày 06/01/2025
            [
                'id' => 1,
                'id_lop_hoc' => 1,
                'id_hoc_sinh' => 1,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 2,
                'id_lop_hoc' => 1,
                'id_hoc_sinh' => 2,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 3,
                'id_lop_hoc' => 1,
                'id_hoc_sinh' => 3,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => false, // Vắng mặt
                'ghi_chu' => 'Bị ốm, phụ huynh đã xin phép',
            ],
            // Lớp Chồi - Ngày 06/01/2025
            [
                'id' => 4,
                'id_lop_hoc' => 2,
                'id_hoc_sinh' => 4,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 5,
                'id_lop_hoc' => 2,
                'id_hoc_sinh' => 5,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 6,
                'id_lop_hoc' => 2,
                'id_hoc_sinh' => 6,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => false, // Vắng mặt
                'ghi_chu' => 'Gia đình có việc',
            ],
            // Lớp Lá - Ngày 06/01/2025
            [
                'id' => 7,
                'id_lop_hoc' => 3,
                'id_hoc_sinh' => 7,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 8,
                'id_lop_hoc' => 3,
                'id_hoc_sinh' => 8,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 9,
                'id_lop_hoc' => 3,
                'id_hoc_sinh' => 9,
                'ngay_diem_danh' => '2025-01-06',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            // Lớp Mầm - Ngày 07/01/2025
            [
                'id' => 10,
                'id_lop_hoc' => 1,
                'id_hoc_sinh' => 1,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 11,
                'id_lop_hoc' => 1,
                'id_hoc_sinh' => 2,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 12,
                'id_lop_hoc' => 1,
                'id_hoc_sinh' => 3,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đã khỏi ốm, trở lại học',
            ],
            // Lớp Chồi - Ngày 07/01/2025
            [
                'id' => 13,
                'id_lop_hoc' => 2,
                'id_hoc_sinh' => 4,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 14,
                'id_lop_hoc' => 2,
                'id_hoc_sinh' => 5,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => false, // Vắng mặt
                'ghi_chu' => 'Bị sốt, phụ huynh đã xin phép',
            ],
            [
                'id' => 15,
                'id_lop_hoc' => 2,
                'id_hoc_sinh' => 6,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đã trở lại học',
            ],
            // Lớp Lá - Ngày 07/01/2025
            [
                'id' => 16,
                'id_lop_hoc' => 3,
                'id_hoc_sinh' => 7,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 17,
                'id_lop_hoc' => 3,
                'id_hoc_sinh' => 8,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => true, // Có mặt
                'ghi_chu' => 'Đi học đầy đủ',
            ],
            [
                'id' => 18,
                'id_lop_hoc' => 3,
                'id_hoc_sinh' => 9,
                'ngay_diem_danh' => '2025-01-07',
                'tinh_trang' => false, // Vắng mặt
                'ghi_chu' => 'Gia đình đi du lịch',
            ],
        ];

        DB::table('diem_danhs')->insert($diemDanhs);
    }
}
