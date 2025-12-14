<?php

namespace Database\Seeders;

use App\Models\MonAn;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonAnBoSungSeeder extends Seeder
{
    /**
     * Thêm nhiều món ăn đa dạng
     */
    public function run(): void
    {
        $monAns = [
            // Món sáng thêm
            [
                'ten_mon' => 'Xôi gà',
                'mo_ta' => 'Xôi nếp với thịt gà xé',
                'ghi_chu' => 'Món sáng bổ dưỡng',
                'hinh_anh' => 'https://i.pinimg.com/1200x/19/46/60/19466061f2ae5a7d2bc7d5f4de7b54a4.jpg',
                'loai_mon' => 'Xôi',
                'nguon_goc' => 'Việt Nam',
                'calo' => 220,
                'protein' => 12.0,
                'carb' => 35.0,
                'fat' => 4.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Mì xào',
                'mo_ta' => 'Mì xào với rau củ và thịt',
                'ghi_chu' => 'Bữa sáng nhanh',
                'hinh_anh' => 'https://cdn.tgdd.vn/Files/2021/09/09/1381268/cach-lam-mi-xao-rau-cu-don-gian-thom-ngon-cho-bua-sang-202109090101120381.jpg',
                'loai_mon' => 'Mì',
                'nguon_goc' => 'Việt Nam',
                'calo' => 280,
                'protein' => 10.0,
                'carb' => 40.0,
                'fat' => 8.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Hủ tiếu',
                'mo_ta' => 'Hủ tiếu với nước dùng ngọt thanh',
                'ghi_chu' => 'Món sáng nhẹ',
                'hinh_anh' => 'https://cooponline.vn/tin-tuc/wp-content/uploads/2025/10/hu-tieu-nam-vang-cong-thuc-nau-chuan-vi-sai-gon-nuoc-dung-ngot-thanh-dam-da-topping.png',
                'loai_mon' => 'Hủ tiếu',
                'nguon_goc' => 'Việt Nam',
                'calo' => 200,
                'protein' => 14.0,
                'carb' => 32.0,
                'fat' => 3.0,
                'is_block' => 0,
            ],

            // Món trưa thêm
            [
                'ten_mon' => 'Cá kho tộ',
                'mo_ta' => 'Cá kho với nước màu đậm đà',
                'ghi_chu' => 'Món mặn bữa trưa',
                'hinh_anh' => 'https://danviet.ex-cdn.com/files/f1/296231569849192448/2022/3/22/1382770671553692663823796403890428162836221n-164791140560584154219.jpg',
                'loai_mon' => 'Cá',
                'nguon_goc' => 'Việt Nam',
                'calo' => 180,
                'protein' => 20.0,
                'carb' => 3.0,
                'fat' => 9.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Thịt kho trứng',
                'mo_ta' => 'Thịt ba chỉ kho với trứng',
                'ghi_chu' => 'Món mặn truyền thống',
                'hinh_anh' => 'https://i.pinimg.com/1200x/7b/05/e1/7b05e1e4f3c8af44ff63a89f6c07049d.jpg',
                'loai_mon' => 'Thịt',
                'nguon_goc' => 'Việt Nam',
                'calo' => 320,
                'protein' => 22.0,
                'carb' => 5.0,
                'fat' => 24.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Canh rau củ',
                'mo_ta' => 'Canh nấu với các loại rau củ',
                'ghi_chu' => 'Canh thanh mát',
                'hinh_anh' => 'https://i.pinimg.com/736x/24/8f/ab/248fab4203753b84fc82a8c8cf0b1326.jpg',
                'loai_mon' => 'Canh',
                'nguon_goc' => 'Việt Nam',
                'calo' => 45,
                'protein' => 2.0,
                'carb' => 8.0,
                'fat' => 0.5,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Đậu hũ sốt cà chua',
                'mo_ta' => 'Đậu hũ chiên giòn sốt cà chua',
                'ghi_chu' => 'Món chay bổ dưỡng',
                'hinh_anh' => 'https://i.pinimg.com/736x/0c/53/1e/0c531efbfbd4c9e4e3a056037a5f1f26.jpg',
                'loai_mon' => 'Đậu hũ',
                'nguon_goc' => 'Việt Nam',
                'calo' => 120,
                'protein' => 8.0,
                'carb' => 10.0,
                'fat' => 6.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Rau muống xào tỏi',
                'mo_ta' => 'Rau muống xào với tỏi',
                'ghi_chu' => 'Rau xanh bổ sung',
                'hinh_anh' => 'https://i.pinimg.com/736x/77/cc/a9/77cca954632d21dbe1a3d9a499e5dbde.jpg',
                'loai_mon' => 'Rau',
                'nguon_goc' => 'Việt Nam',
                'calo' => 35,
                'protein' => 2.5,
                'carb' => 5.0,
                'fat' => 1.0,
                'is_block' => 0,
            ],

            // Món chiều thêm
            [
                'ten_mon' => 'Bánh flan',
                'mo_ta' => 'Bánh flan caramen',
                'ghi_chu' => 'Tráng miệng ngọt',
                'hinh_anh' => 'https://i.pinimg.com/1200x/a0/cc/ec/a0ccec99053bfb6cb53cd1e8648916c3.jpg',
                'loai_mon' => 'Bánh',
                'nguon_goc' => 'Pháp',
                'calo' => 150,
                'protein' => 5.0,
                'carb' => 22.0,
                'fat' => 5.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Chè bắp',
                'mo_ta' => 'Chè bắp nấu với đậu xanh',
                'ghi_chu' => 'Tráng miệng bổ dưỡng',
                'hinh_anh' => 'https://i.pinimg.com/1200x/2c/2c/0f/2c2c0ff9cc064c1bed2ad1748a278824.jpg',
                'loai_mon' => 'Chè',
                'nguon_goc' => 'Việt Nam',
                'calo' => 110,
                'protein' => 3.5,
                'carb' => 20.0,
                'fat' => 1.0,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Trái cây tươi',
                'mo_ta' => 'Các loại trái cây theo mùa',
                'ghi_chu' => 'Bổ sung vitamin',
                'hinh_anh' => 'https://i.pinimg.com/1200x/51/ad/f0/51adf097b401e94d7d304f2e7d4cb226.jpg',
                'loai_mon' => 'Trái cây',
                'nguon_goc' => 'Việt Nam',
                'calo' => 65,
                'protein' => 1.0,
                'carb' => 15.0,
                'fat' => 0.3,
                'is_block' => 0,
            ],
            [
                'ten_mon' => 'Sữa chua',
                'mo_ta' => 'Sữa chua tự nhiên',
                'ghi_chu' => 'Tốt cho tiêu hóa',
                'hinh_anh' => 'https://i.pinimg.com/736x/83/82/2d/83822d410173f2ef2de7b82a7ebde00a.jpg',
                'loai_mon' => 'Sữa',
                'nguon_goc' => 'Việt Nam',
                'calo' => 95,
                'protein' => 5.0,
                'carb' => 12.0,
                'fat' => 3.5,
                'is_block' => 0,
            ],
        ];

        DB::table('mon_ans')->insert($monAns);
        $this->command->info('Đã thêm ' . count($monAns) . ' món ăn mới');
    }
}
