<?php

namespace Database\Seeders;

use App\Models\NhanXet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhanXetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('nhan_xets')->delete();
        DB::table('nhan_xets')->truncate();

        $nhanXets = [
            [
                'id' => 1,
                'id_hoc_sinh' => 1,
                'id_giao_vien' => 1,
                'ngay_nhan_xet' => '2025-01-06',
                'noi_dung' => 'Học sinh ngoan ngoãn, tham gia tích cực các hoạt động học tập. Cần rèn luyện thêm về kỹ năng vẽ và tô màu.',
                'danh_gia' => 'Tốt',

            ],
            [
                'id' => 2,
                'id_hoc_sinh' => 2,
                'id_giao_vien' => 1,
                'ngay_nhan_xet' => '2025-01-06',
                'noi_dung' => 'Học sinh thông minh, tiếp thu nhanh. Có khả năng lãnh đạo tốt trong các hoạt động nhóm.',
                'danh_gia' => 'Xuất sắc',

            ],
            [
                'id' => 3,
                'id_hoc_sinh' => 1,
                'id_giao_vien' => 1,
                'ngay_nhan_xet' => '2025-01-07',
                'noi_dung' => 'Học sinh có tiến bộ trong việc tô màu. Biết giúp đỡ bạn bè và tuân thủ nội quy lớp học.',
                'danh_gia' => 'Tốt',

            ],
            [
                'id' => 4,
                'id_hoc_sinh' => 2,
                'id_giao_vien' => 1,
                'ngay_nhan_xet' => '2025-01-07',
                'noi_dung' => 'Học sinh vắng mặt do ốm. Cần bổ sung kiến thức đã học khi trở lại trường.',
                'danh_gia' => 'Cần cải thiện',

            ],
        ];

        DB::table('nhan_xets')->insert($nhanXets);
    }
}
