<?php

namespace Database\Seeders;

use App\Models\BinhLuan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BinhLuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('binh_luans')->delete();
        DB::table('binh_luans')->truncate();

        $binhLuans = [
            [
                'id' => 1,
                'id_bai_viet' => 1,
                'id_phu_huynh' => 1,
                'noi_dung' => 'Cảm ơn nhà trường đã thông báo sớm để gia đình chuẩn bị kế hoạch cho con.',
                'ngay_binh_luan' => '2025-01-06',

            ],
            [
                'id' => 2,
                'id_bai_viet' => 1,
                'id_phu_huynh' => 2,
                'noi_dung' => 'Thông báo rất hữu ích. Gia đình sẽ sắp xếp thời gian phù hợp.',
                'ngay_binh_luan' => '2025-01-06',

            ],
            [
                'id' => 3,
                'id_bai_viet' => 2,
                'id_phu_huynh' => 1,
                'noi_dung' => 'Hoạt động tham quan vườn thú rất thú vị. Con tôi rất thích động vật.',
                'ngay_binh_luan' => '2025-01-07',

            ],
            [
                'id' => 4,
                'id_bai_viet' => 3,
                'id_phu_huynh' => 2,
                'noi_dung' => 'Bài viết cung cấp thông tin rất hữu ích về dinh dưỡng cho trẻ.',
                'ngay_binh_luan' => '2025-01-08',

            ],
        ];

        DB::table('binh_luans')->insert($binhLuans);
    }
}
