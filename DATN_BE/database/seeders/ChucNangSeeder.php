<?php

namespace Database\Seeders;

use App\Models\ChucNang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    private $idCounter = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('chuc_nangs')->delete();
        DB::table('chuc_nangs')->truncate();

        $chucNangs = [];

        // QUẢN LÝ HỌC SINH
        $chucNangs[] = $this->createChucNang(
            'Quản lý học sinh',
            'Xem danh sách, tìm kiếm, thêm, sửa, xóa, thay đổi trạng thái học sinh'
        );

        // QUẢN LÝ LỚP HỌC
        $chucNangs[] = $this->createChucNang(
            'Quản lý lớp học',
            'Xem danh sách, tìm kiếm, thêm, sửa, xóa, thay đổi trạng thái lớp học'
        );

        // QUẢN LÝ NHÂN VIÊN
        $chucNangs[] = $this->createChucNang(
            'Quản lý nhân viên',
            'Xem danh sách, tìm kiếm, thêm, sửa, xóa, thay đổi trạng thái nhân viên'
        );

        // QUẢN LÝ GIÁO VIÊN
        $chucNangs[] = $this->createChucNang(
            'Quản lý giáo viên',
            'Xem danh sách, tìm kiếm, thêm, sửa, xóa, thay đổi trạng thái giáo viên'
        );

        // QUẢN LÝ PHỤ HUYNH
        $chucNangs[] = $this->createChucNang(
            'Quản lý phụ huynh',
            'Xem danh sách, tìm kiếm, thêm, sửa, xóa, thay đổi trạng thái phụ huynh'
        );

        // QUẢN LÝ ĐIỂM DANH
        $chucNangs[] = $this->createChucNang(
            'Quản lý điểm danh',
            'Xem lịch sử, tìm kiếm, ghi điểm danh, sửa, xóa điểm danh học sinh'
        );

        // QUẢN LÝ SỨC KHỎE
        $chucNangs[] = $this->createChucNang(
            'Quản lý sức khỏe',
            'Xem thông tin, tìm kiếm, ghi nhận, sửa, xóa, thống kê sức khỏe học sinh'
        );

        // QUẢN LÝ THỰC ĐƠN
        $chucNangs[] = $this->createChucNang(
            'Quản lý thực đơn',
            'Xem danh sách, tìm kiếm, tạo, sửa, xóa, thay đổi trạng thái, thống kê thực đơn'
        );

        // QUẢN LÝ HỌC PHÍ
        $chucNangs[] = $this->createChucNang(
            'Quản lý học phí',
            'Xem danh sách, tìm kiếm, tạo, sửa, xóa học phí, xem đóng học phí, thống kê'
        );

        // QUẢN LÝ BÀI VIẾT
        $chucNangs[] = $this->createChucNang(
            'Quản lý bài viết',
            'Xem danh sách, tìm kiếm, đăng, sửa, xóa, thay đổi trạng thái, thống kê bài viết'
        );

        // QUẢN LÝ PHÂN QUYỀN
        $chucNangs[] = $this->createChucNang(
            'Quản lý phân quyền',
            'Xem danh sách, xem phân quyền theo chức vụ, thêm, xóa phân quyền'
        );

        // QUẢN LÝ CHỨC VỤ
        $chucNangs[] = $this->createChucNang(
            'Quản lý chức vụ',
            'Xem danh sách, thêm, sửa, xóa, thay đổi trạng thái chức vụ'
        );

        // QUẢN LÝ NĂM HỌC
        $chucNangs[] = $this->createChucNang(
            'Quản lý năm học',
            'Xem danh sách, tìm kiếm, thêm, sửa, xóa, thay đổi trạng thái năm học'
        );

        DB::table('chuc_nangs')->insert($chucNangs);
    }

    /**
     * Helper method để tạo một chức năng
     */
    private function createChucNang(string $tenChucNang, string $moTa): array
    {
        return [
            'id' => $this->idCounter++,
            'ten_chuc_nang' => $tenChucNang,
            'mo_ta' => $moTa,
        ];
    }
}
