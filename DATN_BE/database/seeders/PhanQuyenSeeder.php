<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhanQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('phan_quyens')->delete();
        DB::table('phan_quyens')->truncate();

        $phanQuyens = [
            // QUẢN LÝ (id_chuc_vu = 1) - Có tất cả quyền (45 chức năng)
            // Học sinh (1-5)
            ['id' => 1, 'id_chuc_nang' => 1, 'id_chuc_vu' => 1], // Xem danh sách học sinh
            ['id' => 2, 'id_chuc_nang' => 2, 'id_chuc_vu' => 1], // Thêm học sinh
            ['id' => 3, 'id_chuc_nang' => 3, 'id_chuc_vu' => 1], // Sửa thông tin học sinh
            ['id' => 4, 'id_chuc_nang' => 4, 'id_chuc_vu' => 1], // Xóa học sinh
            ['id' => 5, 'id_chuc_nang' => 5, 'id_chuc_vu' => 1], // Khóa/Mở khóa học sinh

            // Lớp học (6-9)
            ['id' => 6, 'id_chuc_nang' => 6, 'id_chuc_vu' => 1], // Xem danh sách lớp học
            ['id' => 7, 'id_chuc_nang' => 7, 'id_chuc_vu' => 1], // Thêm lớp học
            ['id' => 8, 'id_chuc_nang' => 8, 'id_chuc_vu' => 1], // Sửa thông tin lớp học
            ['id' => 9, 'id_chuc_nang' => 9, 'id_chuc_vu' => 1], // Xóa lớp học

            // Nhân viên (10-14)
            ['id' => 10, 'id_chuc_nang' => 10, 'id_chuc_vu' => 1], // Xem danh sách nhân viên
            ['id' => 11, 'id_chuc_nang' => 11, 'id_chuc_vu' => 1], // Thêm nhân viên
            ['id' => 12, 'id_chuc_nang' => 12, 'id_chuc_vu' => 1], // Sửa thông tin nhân viên
            ['id' => 13, 'id_chuc_nang' => 13, 'id_chuc_vu' => 1], // Xóa nhân viên
            ['id' => 14, 'id_chuc_nang' => 14, 'id_chuc_vu' => 1], // Khóa/Mở khóa nhân viên

            // Phụ huynh (15-19)
            ['id' => 15, 'id_chuc_nang' => 15, 'id_chuc_vu' => 1], // Xem danh sách phụ huynh
            ['id' => 16, 'id_chuc_nang' => 16, 'id_chuc_vu' => 1], // Thêm phụ huynh
            ['id' => 17, 'id_chuc_nang' => 17, 'id_chuc_vu' => 1], // Sửa thông tin phụ huynh
            ['id' => 18, 'id_chuc_nang' => 18, 'id_chuc_vu' => 1], // Xóa phụ huynh
            ['id' => 19, 'id_chuc_nang' => 19, 'id_chuc_vu' => 1], // Khóa/Mở khóa phụ huynh

            // Điểm danh (20-22)
            ['id' => 20, 'id_chuc_nang' => 20, 'id_chuc_vu' => 1], // Xem điểm danh
            ['id' => 21, 'id_chuc_nang' => 21, 'id_chuc_vu' => 1], // Ghi điểm danh
            ['id' => 22, 'id_chuc_nang' => 22, 'id_chuc_vu' => 1], // Sửa điểm danh

            // Sức khỏe (23-25)
            ['id' => 23, 'id_chuc_nang' => 23, 'id_chuc_vu' => 1], // Xem thông tin sức khỏe
            ['id' => 24, 'id_chuc_nang' => 24, 'id_chuc_vu' => 1], // Ghi thông tin sức khỏe
            ['id' => 25, 'id_chuc_nang' => 25, 'id_chuc_vu' => 1], // Sửa thông tin sức khỏe

            // Thực đơn (26-29)
            ['id' => 26, 'id_chuc_nang' => 26, 'id_chuc_vu' => 1], // Xem thực đơn
            ['id' => 27, 'id_chuc_nang' => 27, 'id_chuc_vu' => 1], // Tạo thực đơn
            ['id' => 28, 'id_chuc_nang' => 28, 'id_chuc_vu' => 1], // Sửa thực đơn
            ['id' => 29, 'id_chuc_nang' => 29, 'id_chuc_vu' => 1], // Xóa thực đơn

            // Học phí (30-34)
            ['id' => 30, 'id_chuc_nang' => 30, 'id_chuc_vu' => 1], // Xem danh sách học phí
            ['id' => 31, 'id_chuc_nang' => 31, 'id_chuc_vu' => 1], // Tạo học phí
            ['id' => 32, 'id_chuc_nang' => 32, 'id_chuc_vu' => 1], // Sửa học phí
            ['id' => 33, 'id_chuc_nang' => 33, 'id_chuc_vu' => 1], // Xóa học phí
            ['id' => 34, 'id_chuc_nang' => 34, 'id_chuc_vu' => 1], // Xem đóng học phí

            // Bài viết (35-38)
            ['id' => 35, 'id_chuc_nang' => 35, 'id_chuc_vu' => 1], // Xem bài viết
            ['id' => 36, 'id_chuc_nang' => 36, 'id_chuc_vu' => 1], // Đăng bài viết
            ['id' => 37, 'id_chuc_nang' => 37, 'id_chuc_vu' => 1], // Sửa bài viết
            ['id' => 38, 'id_chuc_nang' => 38, 'id_chuc_vu' => 1], // Xóa bài viết

            // Phân quyền (39-42)
            ['id' => 39, 'id_chuc_nang' => 39, 'id_chuc_vu' => 1], // Xem phân quyền
            ['id' => 40, 'id_chuc_nang' => 40, 'id_chuc_vu' => 1], // Thêm phân quyền
            ['id' => 41, 'id_chuc_nang' => 41, 'id_chuc_vu' => 1], // Sửa phân quyền
            ['id' => 42, 'id_chuc_nang' => 42, 'id_chuc_vu' => 1], // Xóa phân quyền

            // GIÁO VIÊN (id_chuc_vu = 2) - Quyền giảng dạy và theo dõi
            ['id' => 43, 'id_chuc_nang' => 1, 'id_chuc_vu' => 2], // Xem danh sách học sinh
            ['id' => 44, 'id_chuc_nang' => 6, 'id_chuc_vu' => 2], // Xem danh sách lớp học
            ['id' => 45, 'id_chuc_nang' => 20, 'id_chuc_vu' => 2], // Xem điểm danh
            ['id' => 46, 'id_chuc_nang' => 21, 'id_chuc_vu' => 2], // Ghi điểm danh
            ['id' => 47, 'id_chuc_nang' => 22, 'id_chuc_vu' => 2], // Sửa điểm danh
            ['id' => 48, 'id_chuc_nang' => 23, 'id_chuc_vu' => 2], // Xem thông tin sức khỏe
            ['id' => 49, 'id_chuc_nang' => 24, 'id_chuc_vu' => 2], // Ghi thông tin sức khỏe
            ['id' => 50, 'id_chuc_nang' => 25, 'id_chuc_vu' => 2], // Sửa thông tin sức khỏe
            ['id' => 51, 'id_chuc_nang' => 35, 'id_chuc_vu' => 2], // Xem bài viết

            // NHÂN VIÊN Y TẾ (id_chuc_vu = 3) - Quyền chăm sóc sức khỏe
            ['id' => 52, 'id_chuc_nang' => 1, 'id_chuc_vu' => 3], // Xem danh sách học sinh
            ['id' => 53, 'id_chuc_nang' => 23, 'id_chuc_vu' => 3], // Xem thông tin sức khỏe
            ['id' => 54, 'id_chuc_nang' => 24, 'id_chuc_vu' => 3], // Ghi thông tin sức khỏe
            ['id' => 55, 'id_chuc_nang' => 25, 'id_chuc_vu' => 3], // Sửa thông tin sức khỏe
            ['id' => 56, 'id_chuc_nang' => 26, 'id_chuc_vu' => 3], // Xem thực đơn
            ['id' => 57, 'id_chuc_nang' => 27, 'id_chuc_vu' => 3], // Tạo thực đơn
            ['id' => 58, 'id_chuc_nang' => 28, 'id_chuc_vu' => 3], // Sửa thực đơn

            // NHÂN VIÊN KẾ TOÁN (id_chuc_vu = 4) - Quyền quản lý tài chính
            ['id' => 59, 'id_chuc_nang' => 1, 'id_chuc_vu' => 4], // Xem danh sách học sinh
            ['id' => 60, 'id_chuc_nang' => 30, 'id_chuc_vu' => 4], // Xem danh sách học phí
            ['id' => 61, 'id_chuc_nang' => 31, 'id_chuc_vu' => 4], // Tạo học phí
            ['id' => 62, 'id_chuc_nang' => 32, 'id_chuc_vu' => 4], // Sửa học phí
            ['id' => 63, 'id_chuc_nang' => 33, 'id_chuc_vu' => 4], // Xóa học phí
            ['id' => 64, 'id_chuc_nang' => 34, 'id_chuc_vu' => 4], // Xem đóng học phí

            // NHÂN VIÊN VĂN PHÒNG (id_chuc_vu = 5) - Quyền hành chính
            ['id' => 65, 'id_chuc_nang' => 1, 'id_chuc_vu' => 5], // Xem danh sách học sinh
            ['id' => 66, 'id_chuc_nang' => 6, 'id_chuc_vu' => 5], // Xem danh sách lớp học
            ['id' => 67, 'id_chuc_nang' => 15, 'id_chuc_vu' => 5], // Xem danh sách phụ huynh
            ['id' => 68, 'id_chuc_nang' => 35, 'id_chuc_vu' => 5], // Xem bài viết
            ['id' => 69, 'id_chuc_nang' => 36, 'id_chuc_vu' => 5], // Đăng bài viết
            ['id' => 70, 'id_chuc_nang' => 37, 'id_chuc_vu' => 5], // Sửa bài viết
            ['id' => 71, 'id_chuc_nang' => 38, 'id_chuc_vu' => 5], // Xóa bài viết
        ];

        DB::table('phan_quyens')->insert($phanQuyens);
    }
}
