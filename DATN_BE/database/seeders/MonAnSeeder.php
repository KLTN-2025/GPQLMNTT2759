<?php

namespace Database\Seeders;

use App\Models\MonAn;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonAnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('mon_ans')->delete();
        DB::table('mon_ans')->truncate();

        $monAns = [
            // Món ăn sáng
            [
                'id' => 1,
                'ten_mon' => 'Cháo gà',
                'mo_ta' => 'Cháo gà nấu với gạo tẻ, thịt gà, nấm',
                'ghi_chu' => 'Món ăn sáng bổ dưỡng',
                'hinh_anh' => 'chao-ga.jpg',
                'loai_mon' => 'Cháo',
                'nguon_goc' => 'Việt Nam',
                'calo' => 150,
                'protein' => 8.5,
                'carb' => 25.0,
                'fat' => 2.0,
                'is_block' => false,
            ],
            [
                'id' => 2,
                'ten_mon' => 'Bánh mì sữa',
                'mo_ta' => 'Bánh mì sữa tươi, bơ',
                'ghi_chu' => 'Bữa sáng nhanh gọn',
                'hinh_anh' => 'banh-mi-sua.jpg',
                'loai_mon' => 'Bánh',
                'nguon_goc' => 'Việt Nam',
                'calo' => 120,
                'protein' => 4.0,
                'carb' => 20.0,
                'fat' => 3.5,
                'is_block' => false,
            ],
            [
                'id' => 3,
                'ten_mon' => 'Phở bò',
                'mo_ta' => 'Phở bò với nước dùng đậm đà',
                'ghi_chu' => 'Món ăn truyền thống',
                'hinh_anh' => 'pho-bo.jpg',
                'loai_mon' => 'Phở',
                'nguon_goc' => 'Việt Nam',
                'calo' => 180,
                'protein' => 12.0,
                'carb' => 30.0,
                'fat' => 2.5,
                'is_block' => false,
            ],
            // Món ăn trưa
            [
                'id' => 4,
                'ten_mon' => 'Cơm gà kho',
                'mo_ta' => 'Cơm trắng với gà kho gừng',
                'ghi_chu' => 'Bữa trưa chính',
                'hinh_anh' => 'com-ga-kho.jpg',
                'loai_mon' => 'Cơm',
                'nguon_goc' => 'Việt Nam',
                'calo' => 350,
                'protein' => 25.0,
                'carb' => 45.0,
                'fat' => 8.0,
                'is_block' => false,
            ],
            [
                'id' => 5,
                'ten_mon' => 'Canh chua cá',
                'mo_ta' => 'Canh chua cá với dứa, cà chua',
                'ghi_chu' => 'Canh chua thanh mát',
                'hinh_anh' => 'canh-chua-ca.jpg',
                'loai_mon' => 'Canh',
                'nguon_goc' => 'Việt Nam',
                'calo' => 80,
                'protein' => 15.0,
                'carb' => 5.0,
                'fat' => 1.0,
                'is_block' => false,
            ],
            [
                'id' => 6,
                'ten_mon' => 'Rau xanh luộc',
                'mo_ta' => 'Rau cải, rau muống luộc',
                'ghi_chu' => 'Rau xanh bổ sung vitamin',
                'hinh_anh' => 'rau-xanh.jpg',
                'loai_mon' => 'Rau',
                'nguon_goc' => 'Việt Nam',
                'calo' => 25,
                'protein' => 2.0,
                'carb' => 4.0,
                'fat' => 0.5,
                'is_block' => false,
            ],
            // Món ăn chiều
            [
                'id' => 7,
                'ten_mon' => 'Chè đậu xanh',
                'mo_ta' => 'Chè đậu xanh nấu với đường phèn',
                'ghi_chu' => 'Tráng miệng bổ dưỡng',
                'hinh_anh' => 'che-dau-xanh.jpg',
                'loai_mon' => 'Chè',
                'nguon_goc' => 'Việt Nam',
                'calo' => 100,
                'protein' => 3.0,
                'carb' => 18.0,
                'fat' => 0.5,
                'is_block' => false,
            ],
            [
                'id' => 8,
                'ten_mon' => 'Sữa tươi',
                'mo_ta' => 'Sữa tươi tiệt trùng',
                'ghi_chu' => 'Bổ sung canxi',
                'hinh_anh' => 'sua-tuoi.jpg',
                'loai_mon' => 'Sữa',
                'nguon_goc' => 'Việt Nam',
                'calo' => 80,
                'protein' => 6.0,
                'carb' => 8.0,
                'fat' => 4.0,
                'is_block' => false,
            ],
            // Thêm một số món ăn khác
            [
                'id' => 9,
                'ten_mon' => 'Bún chả',
                'mo_ta' => 'Bún với chả nướng và rau sống',
                'ghi_chu' => 'Món ăn truyền thống Hà Nội',
                'hinh_anh' => 'bun-cha.jpg',
                'loai_mon' => 'Bún',
                'nguon_goc' => 'Việt Nam',
                'calo' => 280,
                'protein' => 18.0,
                'carb' => 35.0,
                'fat' => 6.0,
                'is_block' => false,
            ],
            [
                'id' => 10,
                'ten_mon' => 'Bánh cuốn',
                'mo_ta' => 'Bánh cuốn nhân thịt với nước mắm',
                'ghi_chu' => 'Bữa sáng nhẹ nhàng',
                'hinh_anh' => 'banh-cuon.jpg',
                'loai_mon' => 'Bánh',
                'nguon_goc' => 'Việt Nam',
                'calo' => 160,
                'protein' => 6.0,
                'carb' => 28.0,
                'fat' => 2.5,
                'is_block' => false,
            ],
        ];

        DB::table('mon_ans')->insert($monAns);
    }
}
