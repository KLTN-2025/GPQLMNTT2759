<?php

namespace Database\Seeders;

use App\Models\ChiTietThucDon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietThucDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('chi_tiet_thuc_dons')->delete();
        DB::table('chi_tiet_thuc_dons')->truncate();

        $chiTietThucDons = [
            // Thực đơn thứ 2
            [
                'id' => 1,
                'id_thuc_don' => 1,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 1, // Cháo gà
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần cho trẻ 3-4 tuổi',
            ],
            [
                'id' => 2,
                'id_thuc_don' => 1,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần chính',
            ],
            [
                'id' => 3,
                'id_thuc_don' => 1,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 5, // Canh chua cá
                'so_luong' => 1,
                'ghi_chu' => 'Canh bổ sung',
            ],
            // Thực đơn thứ 3
            [
                'id' => 4,
                'id_thuc_don' => 2,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 2, // Bánh mì sữa
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần cho trẻ 3-4 tuổi',
            ],
            [
                'id' => 5,
                'id_thuc_don' => 2,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần chính',
            ],
            // Thực đơn thứ 4
            [
                'id' => 6,
                'id_thuc_don' => 3,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 3, // Phở bò
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần cho trẻ 3-4 tuổi',
            ],
            [
                'id' => 7,
                'id_thuc_don' => 3,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần chính',
            ],
        ];

        DB::table('chi_tiet_thuc_dons')->insert($chiTietThucDons);
    }
}
