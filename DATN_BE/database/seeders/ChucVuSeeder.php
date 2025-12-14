<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chuc_vus')->delete();
        DB::table('chuc_vus')->truncate();
        $data = [
            ['id' => 1, 'ten_chuc_vu' => 'Hiệu trưởng', 'mo_ta' => 'Người đứng đầu trường học', 'loai_chuc_vu' => '1', 'tinh_trang' => 1],
            ['id' => 2, 'ten_chuc_vu' => 'Phó hiệu trưởng', 'mo_ta' => 'Người hỗ trợ Hiệu trưởng', 'loai_chuc_vu' => '1', 'tinh_trang' => 1],
            ['id' => 3, 'ten_chuc_vu' => 'Giáo viên', 'mo_ta' => 'Người dạy học sinh', 'loai_chuc_vu' => '2', 'tinh_trang' => 1],
            ['id' => 4, 'ten_chuc_vu' => 'Bảo mẫu', 'mo_ta' => 'Người chăm sóc trẻ em', 'loai_chuc_vu' => '2', 'tinh_trang' => 1],
            ['id' => 5, 'ten_chuc_vu' => 'Y tế', 'mo_ta' => 'Người chăm sóc sức khỏe', 'loai_chuc_vu' => '3', 'tinh_trang' => 1],
            ['id' => 6, 'ten_chuc_vu' => 'Nhà bếp', 'mo_ta' => 'Người nấu ăn', 'loai_chuc_vu' => '4', 'tinh_trang' => 1],
            ['id' => 7, 'ten_chuc_vu' => 'Bảo vệ', 'mo_ta' => 'Người bảo vệ an ninh', 'loai_chuc_vu' => '4', 'tinh_trang' => 1],
            ['id' => 8, 'ten_chuc_vu' => 'Kế toán', 'mo_ta' => 'Người quản lý tài chính', 'loai_chuc_vu' => '4', 'tinh_trang' => 1],
            ['id' => 9, 'ten_chuc_vu' => 'Thủ quỹ', 'mo_ta' => 'Người quản lý quỹ', 'loai_chuc_vu' => '4', 'tinh_trang' => 1],
            ['id' => 10, 'ten_chuc_vu' => 'Tạp vụ', 'mo_ta' => 'Người dọn dẹp vệ sinh', 'loai_chuc_vu' => '4', 'tinh_trang' => 1],
        ];

        foreach ($data as &$item) {
            $item['slug_chuc_vu'] = Str::slug($item['ten_chuc_vu']);
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('chuc_vus')->insert($data);
    }
}
