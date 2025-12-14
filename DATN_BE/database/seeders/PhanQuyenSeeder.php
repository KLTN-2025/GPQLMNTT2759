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

        $phanQuyens = [];

        // BAN GIÁM HIỆU (id_chuc_vu = 1: Hiệu trưởng, 2: Phó hiệu trưởng) - Có TẤT CẢ 13 quyền
        for ($chucNang = 1; $chucNang <= 13; $chucNang++) {
            $phanQuyens[] = ['id_chuc_nang' => $chucNang, 'id_chuc_vu' => 1]; // Hiệu trưởng
            $phanQuyens[] = ['id_chuc_nang' => $chucNang, 'id_chuc_vu' => 2]; // Phó hiệu trưởng
        }

        // GIÁO VIÊN (id_chuc_vu = 3) - Quyền liên quan đến giảng dạy và theo dõi
        $phanQuyens[] = ['id_chuc_nang' => 1, 'id_chuc_vu' => 3]; // Quản lý học sinh
        $phanQuyens[] = ['id_chuc_nang' => 2, 'id_chuc_vu' => 3]; // Quản lý lớp học
        $phanQuyens[] = ['id_chuc_nang' => 6, 'id_chuc_vu' => 3]; // Quản lý điểm danh
        $phanQuyens[] = ['id_chuc_nang' => 7, 'id_chuc_vu' => 3]; // Quản lý sức khỏe
        $phanQuyens[] = ['id_chuc_nang' => 10, 'id_chuc_vu' => 3]; // Quản lý bài viết

        // BẢO MẪU (id_chuc_vu = 4) - Quyền liên quan đến chăm sóc trẻ em
        $phanQuyens[] = ['id_chuc_nang' => 1, 'id_chuc_vu' => 4]; // Quản lý học sinh
        $phanQuyens[] = ['id_chuc_nang' => 6, 'id_chuc_vu' => 4]; // Quản lý điểm danh
        $phanQuyens[] = ['id_chuc_nang' => 7, 'id_chuc_vu' => 4]; // Quản lý sức khỏe

        // Y TẾ (id_chuc_vu = 5) - Quyền liên quan đến chăm sóc sức khỏe
        $phanQuyens[] = ['id_chuc_nang' => 1, 'id_chuc_vu' => 5]; // Quản lý học sinh
        $phanQuyens[] = ['id_chuc_nang' => 7, 'id_chuc_vu' => 5]; // Quản lý sức khỏe
        $phanQuyens[] = ['id_chuc_nang' => 8, 'id_chuc_vu' => 5]; // Quản lý thực đơn

        // NHÀ BẾP (id_chuc_vu = 6) - Quyền liên quan đến thực đơn
        $phanQuyens[] = ['id_chuc_nang' => 8, 'id_chuc_vu' => 6]; // Quản lý thực đơn

        // BẢO VỆ (id_chuc_vu = 7) - Quyền xem thông tin cơ bản
        $phanQuyens[] = ['id_chuc_nang' => 1, 'id_chuc_vu' => 7]; // Quản lý học sinh (xem)

        // KẾ TOÁN (id_chuc_vu = 8) - Quyền liên quan đến tài chính
        $phanQuyens[] = ['id_chuc_nang' => 1, 'id_chuc_vu' => 8]; // Quản lý học sinh
        $phanQuyens[] = ['id_chuc_nang' => 9, 'id_chuc_vu' => 8]; // Quản lý học phí

        // THỦ QUỸ (id_chuc_vu = 9) - Quyền liên quan đến quản lý quỹ
        $phanQuyens[] = ['id_chuc_nang' => 1, 'id_chuc_vu' => 9]; // Quản lý học sinh
        $phanQuyens[] = ['id_chuc_nang' => 9, 'id_chuc_vu' => 9]; // Quản lý học phí

        // TẠP VỤ (id_chuc_vu = 10) - Không có quyền đặc biệt

        // Thêm timestamps
        foreach ($phanQuyens as &$phanQuyen) {
            $phanQuyen['created_at'] = now();
            $phanQuyen['updated_at'] = now();
        }

        DB::table('phan_quyens')->insert($phanQuyens);
    }
}
