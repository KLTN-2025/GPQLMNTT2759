<?php

namespace Database\Seeders;

use App\Models\ChiTietThongBao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietThongBaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chi_tiet_thong_baos')->delete();
        DB::table('chi_tiet_thong_baos')->truncate();

        $chiTietThongBaos = [];

        // Thông báo 1: Thông báo chung - gửi tất cả lớp (lớp 1-20)
        for ($lopId = 1; $lopId <= 20; $lopId++) {
            // Lấy giáo viên chủ nhiệm của lớp (theo LopHocSeeder: id_giao_vien = id lớp)
            $giaoVienId = $lopId;

            // Mỗi lớp có khoảng 25 học sinh, mỗi học sinh có 1-2 phụ huynh
            // Chọn ngẫu nhiên 10-15 phụ huynh cho mỗi lớp
            $phuHuynhIds = range(1, 250); // Có 250 phụ huynh
            $selectedParents = array_rand($phuHuynhIds, min(15, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 1,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 2: Học phí - gửi tất cả lớp
        for ($lopId = 1; $lopId <= 20; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(15, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 2,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 3: Hoạt động - gửi các lớp 1-10
        for ($lopId = 1; $lopId <= 10; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(12, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 3,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 4: Thực đơn - gửi tất cả lớp
        for ($lopId = 1; $lopId <= 20; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(10, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 4,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 5: Y tế - gửi các lớp 1-15
        for ($lopId = 1; $lopId <= 15; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(15, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 5,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 6: Chương trình học - gửi tất cả lớp
        for ($lopId = 1; $lopId <= 20; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(12, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 6,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 7: Học phí - gửi tất cả lớp
        for ($lopId = 1; $lopId <= 20; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(15, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 7,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        // Thông báo 8: Họp phụ huynh - gửi tất cả lớp
        for ($lopId = 1; $lopId <= 20; $lopId++) {
            $giaoVienId = $lopId;
            $phuHuynhIds = range(1, 250);
            $selectedParents = array_rand($phuHuynhIds, min(20, count($phuHuynhIds)));
            if (!is_array($selectedParents)) {
                $selectedParents = [$selectedParents];
            }

            foreach ($selectedParents as $parentIndex) {
                $chiTietThongBaos[] = [
                    'id_thong_bao' => 8,
                    'id_phu_huynh' => $phuHuynhIds[$parentIndex] + 1,
                    'id_giao_vien' => $giaoVienId,
                    'id_lop_hoc' => $lopId,
                ];
            }
        }

        DB::table('chi_tiet_thong_baos')->insert($chiTietThongBaos);
    }
}
