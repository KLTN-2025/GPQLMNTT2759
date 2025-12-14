<?php

namespace Database\Seeders;

use App\Models\LoaiBaiViet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiBaiVietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('loai_bai_viets')->delete();
        DB::table('loai_bai_viets')->truncate();

        $loaiBaiViets = [
            [
                'id' => 1,
                'ten_loai' => 'Thông báo',
                'mo_ta' => 'Các thông báo quan trọng từ nhà trường',
                'tinh_trang' => 1,
            ],
            [
                'id' => 2,
                'ten_loai' => 'Tin tức',
                'mo_ta' => 'Tin tức về hoạt động của trường',
                'tinh_trang' => 1,
            ],
            [
                'id' => 3,
                'ten_loai' => 'Sự kiện',
                'mo_ta' => 'Các sự kiện, lễ hội của trường',
                'tinh_trang' => 1,
            ],
            [
                'id' => 4,
                'ten_loai' => 'Kiến thức',
                'mo_ta' => 'Kiến thức nuôi dạy trẻ',
                'tinh_trang' => 1,
            ],
            [
                'id' => 5,
                'ten_loai' => 'Hoạt động',
                'mo_ta' => 'Các hoạt động ngoại khóa, học tập',
                'tinh_trang' => 1,
            ],
        ];

        DB::table('loai_bai_viets')->insert($loaiBaiViets);
    }
}
