<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhoiLopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('khoi_lops')->delete();
        DB::table('khoi_lops')->truncate();

        $khoiLops = [
            [
                'id' => 1,
                'ten_khoi_lop' => 'Nhà trẻ',
                'do_tuoi' => '18-36 tháng',
                'mo_ta' => 'Khối lớp dành cho trẻ từ 18-36 tháng tuổi',

            ],
            [
                'id' => 2,
                'ten_khoi_lop' => 'Mầm',
                'do_tuoi' => '3-4 tuổi',
                'mo_ta' => 'Khối lớp dành cho trẻ từ 3-4 tuổi',

            ],
            [
                'id' => 3,
                'ten_khoi_lop' => 'Chồi',
                'do_tuoi' => '4-5 tuổi',
                'mo_ta' => 'Khối lớp dành cho trẻ từ 4-5 tuổi',

            ],
            [
                'id' => 4,
                'ten_khoi_lop' => 'Lá',
                'do_tuoi' => '5-6 tuổi',
                'mo_ta' => 'Khối lớp dành cho trẻ từ 5-6 tuổi, chuẩn bị vào lớp 1',

            ],
        ];

        DB::table('khoi_lops')->insert($khoiLops);
    }
}
