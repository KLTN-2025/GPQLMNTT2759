<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NamHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('nam_hocs')->delete();
        DB::table('nam_hocs')->truncate();

        $namHocs = [
            [
                'id' => 1,
                'ten_nam_hoc' => '2023-2024',
                'ngay_bat_dau' => '2023-09-05',
                'ngay_ket_thuc' => '2024-05-31',

            ],
            [
                'id' => 2,
                'ten_nam_hoc' => '2024-2025',
                'ngay_bat_dau' => '2024-09-02',
                'ngay_ket_thuc' => '2025-05-30',

            ],
            [
                'id' => 3,
                'ten_nam_hoc' => '2025-2026',
                'ngay_bat_dau' => '2025-09-01',
                'ngay_ket_thuc' => '2026-05-29',

            ],
        ];

        DB::table('nam_hocs')->insert($namHocs);
    }
}
