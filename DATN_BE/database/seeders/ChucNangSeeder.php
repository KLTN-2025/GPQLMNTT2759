<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('chuc_nangs')->delete();
        DB::table('chuc_nangs')->truncate();

        $chucNangs = [
            // QUẢN LÝ HỌC SINH
            [
                'id' => 1,
                'ten_chuc_nang' => 'Xem danh sách học sinh',
                'mo_ta' => 'Xem danh sách tất cả học sinh trong trường',

            ],
            [
                'id' => 2,
                'ten_chuc_nang' => 'Thêm học sinh',
                'mo_ta' => 'Thêm học sinh mới vào hệ thống',

            ],
            [
                'id' => 3,
                'ten_chuc_nang' => 'Sửa thông tin học sinh',
                'mo_ta' => 'Cập nhật thông tin học sinh',

            ],
            [
                'id' => 4,
                'ten_chuc_nang' => 'Xóa học sinh',
                'mo_ta' => 'Xóa học sinh khỏi hệ thống',

            ],
            [
                'id' => 5,
                'ten_chuc_nang' => 'Khóa/Mở khóa học sinh',
                'mo_ta' => 'Thay đổi trạng thái hoạt động của học sinh',

            ],

            // QUẢN LÝ LỚP HỌC
            [
                'id' => 6,
                'ten_chuc_nang' => 'Xem danh sách lớp học',
                'mo_ta' => 'Xem danh sách tất cả lớp học',

            ],
            [
                'id' => 7,
                'ten_chuc_nang' => 'Thêm lớp học',
                'mo_ta' => 'Tạo lớp học mới',

            ],
            [
                'id' => 8,
                'ten_chuc_nang' => 'Sửa thông tin lớp học',
                'mo_ta' => 'Cập nhật thông tin lớp học',

            ],
            [
                'id' => 9,
                'ten_chuc_nang' => 'Xóa lớp học',
                'mo_ta' => 'Xóa lớp học khỏi hệ thống',

            ],

            // QUẢN LÝ NHÂN VIÊN
            [
                'id' => 10,
                'ten_chuc_nang' => 'Xem danh sách nhân viên',
                'mo_ta' => 'Xem danh sách tất cả nhân viên',

            ],
            [
                'id' => 11,
                'ten_chuc_nang' => 'Thêm nhân viên',
                'mo_ta' => 'Thêm nhân viên mới vào hệ thống',

            ],
            [
                'id' => 12,
                'ten_chuc_nang' => 'Sửa thông tin nhân viên',
                'mo_ta' => 'Cập nhật thông tin nhân viên',

            ],
            [
                'id' => 13,
                'ten_chuc_nang' => 'Xóa nhân viên',
                'mo_ta' => 'Xóa nhân viên khỏi hệ thống',

            ],
            [
                'id' => 14,
                'ten_chuc_nang' => 'Khóa/Mở khóa nhân viên',
                'mo_ta' => 'Thay đổi trạng thái hoạt động của nhân viên',

            ],

            // QUẢN LÝ PHỤ HUYNH
            [
                'id' => 15,
                'ten_chuc_nang' => 'Xem danh sách phụ huynh',
                'mo_ta' => 'Xem danh sách tất cả phụ huynh',

            ],
            [
                'id' => 16,
                'ten_chuc_nang' => 'Thêm phụ huynh',
                'mo_ta' => 'Thêm phụ huynh mới vào hệ thống',

            ],
            [
                'id' => 17,
                'ten_chuc_nang' => 'Sửa thông tin phụ huynh',
                'mo_ta' => 'Cập nhật thông tin phụ huynh',

            ],
            [
                'id' => 18,
                'ten_chuc_nang' => 'Xóa phụ huynh',
                'mo_ta' => 'Xóa phụ huynh khỏi hệ thống',

            ],
            [
                'id' => 19,
                'ten_chuc_nang' => 'Khóa/Mở khóa phụ huynh',
                'mo_ta' => 'Thay đổi trạng thái hoạt động của phụ huynh',

            ],

            // QUẢN LÝ ĐIỂM DANH
            [
                'id' => 20,
                'ten_chuc_nang' => 'Xem điểm danh',
                'mo_ta' => 'Xem lịch sử điểm danh học sinh',

            ],
            [
                'id' => 21,
                'ten_chuc_nang' => 'Ghi điểm danh',
                'mo_ta' => 'Ghi nhận điểm danh học sinh hàng ngày',

            ],
            [
                'id' => 22,
                'ten_chuc_nang' => 'Sửa điểm danh',
                'mo_ta' => 'Cập nhật thông tin điểm danh',

            ],

            // QUẢN LÝ SỨC KHỎE
            [
                'id' => 23,
                'ten_chuc_nang' => 'Xem thông tin sức khỏe',
                'mo_ta' => 'Xem lịch sử sức khỏe học sinh',

            ],
            [
                'id' => 24,
                'ten_chuc_nang' => 'Ghi thông tin sức khỏe',
                'mo_ta' => 'Ghi nhận thông tin sức khỏe học sinh',

            ],
            [
                'id' => 25,
                'ten_chuc_nang' => 'Sửa thông tin sức khỏe',
                'mo_ta' => 'Cập nhật thông tin sức khỏe',

            ],

            // QUẢN LÝ THỰC ĐƠN
            [
                'id' => 26,
                'ten_chuc_nang' => 'Xem thực đơn',
                'mo_ta' => 'Xem danh sách thực đơn',

            ],
            [
                'id' => 27,
                'ten_chuc_nang' => 'Tạo thực đơn',
                'mo_ta' => 'Tạo thực đơn mới',

            ],
            [
                'id' => 28,
                'ten_chuc_nang' => 'Sửa thực đơn',
                'mo_ta' => 'Cập nhật thông tin thực đơn',

            ],
            [
                'id' => 29,
                'ten_chuc_nang' => 'Xóa thực đơn',
                'mo_ta' => 'Xóa thực đơn khỏi hệ thống',

            ],

            // QUẢN LÝ HỌC PHÍ
            [
                'id' => 30,
                'ten_chuc_nang' => 'Xem danh sách học phí',
                'mo_ta' => 'Xem danh sách các khoản học phí',

            ],
            [
                'id' => 31,
                'ten_chuc_nang' => 'Tạo học phí',
                'mo_ta' => 'Tạo khoản học phí mới',

            ],
            [
                'id' => 32,
                'ten_chuc_nang' => 'Sửa học phí',
                'mo_ta' => 'Cập nhật thông tin học phí',

            ],
            [
                'id' => 33,
                'ten_chuc_nang' => 'Xóa học phí',
                'mo_ta' => 'Xóa khoản học phí',

            ],
            [
                'id' => 34,
                'ten_chuc_nang' => 'Xem đóng học phí',
                'mo_ta' => 'Xem lịch sử đóng học phí',

            ],

            // QUẢN LÝ BÀI VIẾT
            [
                'id' => 35,
                'ten_chuc_nang' => 'Xem bài viết',
                'mo_ta' => 'Xem danh sách bài viết, thông báo',

            ],
            [
                'id' => 36,
                'ten_chuc_nang' => 'Đăng bài viết',
                'mo_ta' => 'Đăng bài viết, thông báo mới',

            ],
            [
                'id' => 37,
                'ten_chuc_nang' => 'Sửa bài viết',
                'mo_ta' => 'Cập nhật nội dung bài viết',

            ],
            [
                'id' => 38,
                'ten_chuc_nang' => 'Xóa bài viết',
                'mo_ta' => 'Xóa bài viết khỏi hệ thống',

            ],

            // QUẢN LÝ PHÂN QUYỀN
            [
                'id' => 39,
                'ten_chuc_nang' => 'Xem phân quyền',
                'mo_ta' => 'Xem danh sách phân quyền hiện tại',

            ],
            [
                'id' => 40,
                'ten_chuc_nang' => 'Thêm phân quyền',
                'mo_ta' => 'Thêm phân quyền mới cho vai trò',

            ],
            [
                'id' => 41,
                'ten_chuc_nang' => 'Sửa phân quyền',
                'mo_ta' => 'Cập nhật phân quyền',

            ],
            [
                'id' => 42,
                'ten_chuc_nang' => 'Xóa phân quyền',
                'mo_ta' => 'Xóa phân quyền khỏi hệ thống',
                
            ],
        ];

        DB::table('chuc_nangs')->insert($chucNangs);
    }
}

