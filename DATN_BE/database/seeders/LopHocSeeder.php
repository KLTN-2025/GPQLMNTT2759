<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LopHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lop_hocs')->delete();
        DB::table('lop_hocs')->truncate();

        DB::table('lop_hocs')->insert(
            [
                ['id' => 1, 'ten_lop' => 'Lớp Mầm 1', 'id_khoi_lop' => 1, 'id_nam_hoc' => 1, 'id_giao_vien' => 1, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 2, 'ten_lop' => 'Lớp Mầm 2', 'id_khoi_lop' => 1, 'id_nam_hoc' => 1, 'id_giao_vien' => 2, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 3, 'ten_lop' => 'Lớp Mầm 3', 'id_khoi_lop' => 1, 'id_nam_hoc' => 1, 'id_giao_vien' => 3, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 4, 'ten_lop' => 'Lớp Mầm 4', 'id_khoi_lop' => 1, 'id_nam_hoc' => 1, 'id_giao_vien' => 4, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 5, 'ten_lop' => 'Lớp Mầm 5', 'id_khoi_lop' => 1, 'id_nam_hoc' => 1, 'id_giao_vien' => 5, 'so_luong' => 25, 'is_block' => 0,],

                ['id' => 6, 'ten_lop' => 'Lớp Chồi 1', 'id_khoi_lop' => 2, 'id_nam_hoc' => 1, 'id_giao_vien' => 6, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 7, 'ten_lop' => 'Lớp Chồi 2', 'id_khoi_lop' => 2, 'id_nam_hoc' => 1, 'id_giao_vien' => 7, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 8, 'ten_lop' => 'Lớp Chồi 3', 'id_khoi_lop' => 2, 'id_nam_hoc' => 1, 'id_giao_vien' => 8, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 9, 'ten_lop' => 'Lớp Chồi 4', 'id_khoi_lop' => 2, 'id_nam_hoc' => 1, 'id_giao_vien' => 9, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 10, 'ten_lop' => 'Lớp Chồi 5', 'id_khoi_lop' => 2, 'id_nam_hoc' => 1, 'id_giao_vien' => 10, 'so_luong' => 25, 'is_block' => 0,],

                ['id' => 11, 'ten_lop' => 'Lớp Lá 1', 'id_khoi_lop' => 3, 'id_nam_hoc' => 1, 'id_giao_vien' => 11, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 12, 'ten_lop' => 'Lớp Lá 2', 'id_khoi_lop' => 3, 'id_nam_hoc' => 1, 'id_giao_vien' => 12, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 13, 'ten_lop' => 'Lớp Lá 3', 'id_khoi_lop' => 3, 'id_nam_hoc' => 1, 'id_giao_vien' => 13, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 14, 'ten_lop' => 'Lớp Lá 4', 'id_khoi_lop' => 3, 'id_nam_hoc' => 1, 'id_giao_vien' => 14, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 15, 'ten_lop' => 'Lớp Lá 5', 'id_khoi_lop' => 3, 'id_nam_hoc' => 1, 'id_giao_vien' => 15, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 16, 'ten_lop' => 'Lớp Tổng hợp 1', 'id_khoi_lop' => 4, 'id_nam_hoc' => 1, 'id_giao_vien' => 16, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 17, 'ten_lop' => 'Lớp Tổng hợp 2', 'id_khoi_lop' => 4, 'id_nam_hoc' => 1, 'id_giao_vien' => 17, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 18, 'ten_lop' => 'Lớp Năng Khiếu', 'id_khoi_lop' => 4, 'id_nam_hoc' => 1, 'id_giao_vien' => 18, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 19, 'ten_lop' => 'Lớp Song Ngữ', 'id_khoi_lop' => 4, 'id_nam_hoc' => 1, 'id_giao_vien' => 19, 'so_luong' => 25, 'is_block' => 0,],
                ['id' => 20, 'ten_lop' => 'Lớp Đặc Biệt', 'id_khoi_lop' => 4, 'id_nam_hoc' => 1, 'id_giao_vien' => 20, 'so_luong' => 25, 'is_block' => 0,],
            ]
        );
    }
}
