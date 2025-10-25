<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThucDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('thuc_dons')->delete();
        DB::table('thuc_dons')->truncate();

        $thucDons = [
            [
                'id' => 1,
                'ten_thuc_don' => 'Thực đơn thứ 2',
                'ngay' => '2025-01-06',
                'mo_ta' => 'Thực đơn dinh dưỡng cho thứ 2',

            ],
            [
                'id' => 2,
                'ten_thuc_don' => 'Thực đơn thứ 3',
                'ngay' => '2025-01-07',
                'mo_ta' => 'Thực đơn dinh dưỡng cho thứ 3',

            ],
            [
                'id' => 3,
                'ten_thuc_don' => 'Thực đơn thứ 4',
                'ngay' => '2025-01-08',
                'mo_ta' => 'Thực đơn dinh dưỡng cho thứ 4',

            ],
            [
                'id' => 4,
                'ten_thuc_don' => 'Thực đơn thứ 5',
                'ngay' => '2025-01-09',
                'mo_ta' => 'Thực đơn dinh dưỡng cho thứ 5',

            ],
            [
                'id' => 5,
                'ten_thuc_don' => 'Thực đơn thứ 6',
                'ngay' => '2025-01-10',
                'mo_ta' => 'Thực đơn dinh dưỡng cho thứ 6',

            ],
        ];

        DB::table('thuc_dons')->insert($thucDons);
    }
}
