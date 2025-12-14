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
            // ============================================
            // THỰC ĐƠN THỨ 2 (id_thuc_don = 1)
            // ============================================
            [
                'id_thuc_don' => 1,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 1, // Cháo gà
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần cho trẻ 3-4 tuổi',
            ],
            [
                'id_thuc_don' => 1,
                'id_bua_an' => 2, // Bữa phụ sáng
                'id_mon_an' => 8, // Sữa tươi
                'so_luong' => 1,
                'ghi_chu' => 'Bổ sung canxi và dinh dưỡng',
            ],
            [
                'id_thuc_don' => 1,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần chính',
            ],
            [
                'id_thuc_don' => 1,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 5, // Canh chua cá
                'so_luong' => 1,
                'ghi_chu' => 'Canh bổ sung',
            ],
            [
                'id_thuc_don' => 1,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 6, // Rau xanh luộc
                'so_luong' => 1,
                'ghi_chu' => 'Rau xanh bổ sung vitamin',
            ],
            [
                'id_thuc_don' => 1,
                'id_bua_an' => 4, // Bữa phụ chiều
                'id_mon_an' => 7, // Chè đậu xanh
                'so_luong' => 1,
                'ghi_chu' => 'Tráng miệng bổ dưỡng',
            ],

            // ============================================
            // THỰC ĐƠN THỨ 3 (id_thuc_don = 2)
            // ============================================
            [
                'id_thuc_don' => 2,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 2, // Bánh mì sữa
                'so_luong' => 1,
                'ghi_chu' => 'Bữa sáng nhanh gọn',
            ],
            [
                'id_thuc_don' => 2,
                'id_bua_an' => 2, // Bữa phụ sáng
                'id_mon_an' => 8, // Sữa tươi
                'so_luong' => 1,
                'ghi_chu' => 'Bổ sung canxi',
            ],
            [
                'id_thuc_don' => 2,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 9, // Bún chả
                'so_luong' => 1,
                'ghi_chu' => 'Món ăn truyền thống',
            ],
            [
                'id_thuc_don' => 2,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 6, // Rau xanh luộc
                'so_luong' => 1,
                'ghi_chu' => 'Rau xanh bổ sung',
            ],
            [
                'id_thuc_don' => 2,
                'id_bua_an' => 4, // Bữa phụ chiều
                'id_mon_an' => 7, // Chè đậu xanh
                'so_luong' => 1,
                'ghi_chu' => 'Tráng miệng',
            ],

            // ============================================
            // THỰC ĐƠN THỨ 4 (id_thuc_don = 3)
            // ============================================
            [
                'id_thuc_don' => 3,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 3, // Phở bò
                'so_luong' => 1,
                'ghi_chu' => 'Món ăn truyền thống',
            ],
            [
                'id_thuc_don' => 3,
                'id_bua_an' => 2, // Bữa phụ sáng
                'id_mon_an' => 8, // Sữa tươi
                'so_luong' => 1,
                'ghi_chu' => 'Bổ sung dinh dưỡng',
            ],
            [
                'id_thuc_don' => 3,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần chính',
            ],
            [
                'id_thuc_don' => 3,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 5, // Canh chua cá
                'so_luong' => 1,
                'ghi_chu' => 'Canh bổ sung',
            ],
            [
                'id_thuc_don' => 3,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 6, // Rau xanh luộc
                'so_luong' => 1,
                'ghi_chu' => 'Rau xanh',
            ],
            [
                'id_thuc_don' => 3,
                'id_bua_an' => 4, // Bữa phụ chiều
                'id_mon_an' => 7, // Chè đậu xanh
                'so_luong' => 1,
                'ghi_chu' => 'Tráng miệng',
            ],

            // ============================================
            // THỰC ĐƠN THỨ 5 (id_thuc_don = 4)
            // ============================================
            [
                'id_thuc_don' => 4,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 10, // Bánh cuốn
                'so_luong' => 1,
                'ghi_chu' => 'Bữa sáng nhẹ nhàng',
            ],
            [
                'id_thuc_don' => 4,
                'id_bua_an' => 2, // Bữa phụ sáng
                'id_mon_an' => 8, // Sữa tươi
                'so_luong' => 1,
                'ghi_chu' => 'Bổ sung canxi',
            ],
            [
                'id_thuc_don' => 4,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần chính',
            ],
            [
                'id_thuc_don' => 4,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 5, // Canh chua cá
                'so_luong' => 1,
                'ghi_chu' => 'Canh bổ sung',
            ],
            [
                'id_thuc_don' => 4,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 6, // Rau xanh luộc
                'so_luong' => 1,
                'ghi_chu' => 'Rau xanh',
            ],
            [
                'id_thuc_don' => 4,
                'id_bua_an' => 4, // Bữa phụ chiều
                'id_mon_an' => 7, // Chè đậu xanh
                'so_luong' => 1,
                'ghi_chu' => 'Tráng miệng',
            ],

            // ============================================
            // THỰC ĐƠN THỨ 6 (id_thuc_don = 5)
            // ============================================
            [
                'id_thuc_don' => 5,
                'id_bua_an' => 1, // Bữa sáng
                'id_mon_an' => 1, // Cháo gà
                'so_luong' => 1,
                'ghi_chu' => 'Khẩu phần cho trẻ 3-4 tuổi',
            ],
            [
                'id_thuc_don' => 5,
                'id_bua_an' => 2, // Bữa phụ sáng
                'id_mon_an' => 8, // Sữa tươi
                'so_luong' => 1,
                'ghi_chu' => 'Bổ sung dinh dưỡng',
            ],
            [
                'id_thuc_don' => 5,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 9, // Bún chả
                'so_luong' => 1,
                'ghi_chu' => 'Món ăn truyền thống',
            ],
            [
                'id_thuc_don' => 5,
                'id_bua_an' => 3, // Bữa trưa
                'id_mon_an' => 6, // Rau xanh luộc
                'so_luong' => 1,
                'ghi_chu' => 'Rau xanh bổ sung',
            ],
            [
                'id_thuc_don' => 5,
                'id_bua_an' => 4, // Bữa phụ chiều
                'id_mon_an' => 7, // Chè đậu xanh
                'so_luong' => 1,
                'ghi_chu' => 'Tráng miệng',
            ],
            [
                'id_thuc_don' => 5,
                'id_bua_an' => 5, // Bữa chiều
                'id_mon_an' => 4, // Cơm gà kho
                'so_luong' => 1,
                'ghi_chu' => 'Bữa chiều nhẹ',
            ],
        ];

        DB::table('chi_tiet_thuc_dons')->insert($chiTietThucDons);
    }
}
