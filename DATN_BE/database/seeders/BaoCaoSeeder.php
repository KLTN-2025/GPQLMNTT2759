<?php

namespace Database\Seeders;

use App\Models\BaoCao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaoCaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bao_caos')->delete();
        DB::table('bao_caos')->truncate();

        $baoCaos = [
            [
                'id' => 1,
                'id_giao_vien' => 1,
                'id_nhan_vien' => 1,
                'loai_bao_cao' => 1, // Báo cáo tuần
                'tieu_de' => 'Báo cáo tuần 1 tháng 1/2025 - Lớp Mầm 1',
                'duong_dan' => 'baocao_tuan1_thang1_lopmam1.pdf',
                'ngay_tao' => '2025-01-05 17:00:00',
                'ngay_ky' => '2025-01-06',
                'tinh_trang' => 1,
            ],
            [
                'id' => 2,
                'id_giao_vien' => 2,
                'id_nhan_vien' => 1,
                'loai_bao_cao' => 1,
                'tieu_de' => 'Báo cáo tuần 1 tháng 1/2025 - Lớp Mầm 2',
                'duong_dan' => 'baocao_tuan1_thang1_lopmam2.pdf',
                'ngay_tao' => '2025-01-05 17:00:00',
                'ngay_ky' => '2025-01-06',
                'tinh_trang' => 1,
            ],
            [
                'id' => 3,
                'id_giao_vien' => 3,
                'id_nhan_vien' => 1,
                'loai_bao_cao' => 2, // Báo cáo tháng
                'tieu_de' => 'Báo cáo tháng 1/2025 - Lớp Mầm 3',
                'duong_dan' => 'baocao_thang1_lopmam3.pdf',
                'ngay_tao' => '2025-01-31 17:00:00',
                'ngay_ky' => '2025-02-01',
                'tinh_trang' => 1,
            ],
            [
                'id' => 4,
                'id_giao_vien' => 6,
                'id_nhan_vien' => 2,
                'loai_bao_cao' => 1,
                'tieu_de' => 'Báo cáo tuần 2 tháng 2/2025 - Lớp Chồi 1',
                'duong_dan' => 'baocao_tuan2_thang2_lopchoi1.pdf',
                'ngay_tao' => '2025-02-10 17:00:00',
                'ngay_ky' => '2025-02-11',
                'tinh_trang' => 1,
            ],
            [
                'id' => 5,
                'id_giao_vien' => 11,
                'id_nhan_vien' => 1,
                'loai_bao_cao' => 2,
                'tieu_de' => 'Báo cáo tháng 2/2025 - Lớp Lá 1',
                'duong_dan' => 'baocao_thang2_lopla1.pdf',
                'ngay_tao' => '2025-02-28 17:00:00',
                'ngay_ky' => '2025-03-01',
                'tinh_trang' => 1,
            ],
            [
                'id' => 6,
                'id_giao_vien' => 5,
                'id_nhan_vien' => 2,
                'loai_bao_cao' => 3, // Báo cáo học kỳ
                'tieu_de' => 'Báo cáo học kỳ 1 năm học 2024-2025 - Lớp Mầm 5',
                'duong_dan' => 'baocao_hocky1_lopmam5.pdf',
                'ngay_tao' => '2025-03-15 17:00:00',
                'ngay_ky' => '2025-03-20',
                'tinh_trang' => 1,
            ],
            [
                'id' => 7,
                'id_giao_vien' => 10,
                'id_nhan_vien' => 3,
                'loai_bao_cao' => 1,
                'tieu_de' => 'Báo cáo tuần 3 tháng 3/2025 - Lớp Chồi 5',
                'duong_dan' => 'baocao_tuan3_thang3_lopchoi5.pdf',
                'ngay_tao' => '2025-03-20 17:00:00',
                'ngay_ky' => '2025-03-21',
                'tinh_trang' => 1,
            ],
            [
                'id' => 8,
                'id_giao_vien' => 15,
                'id_nhan_vien' => 1,
                'loai_bao_cao' => 2,
                'tieu_de' => 'Báo cáo tháng 3/2025 - Lớp Lá 5',
                'duong_dan' => 'baocao_thang3_lopla5.pdf',
                'ngay_tao' => '2025-03-31 17:00:00',
                'ngay_ky' => '2025-04-01',
                'tinh_trang' => 1,
            ],
            [
                'id' => 9,
                'id_giao_vien' => 18,
                'id_nhan_vien' => 2,
                'loai_bao_cao' => 1,
                'tieu_de' => 'Báo cáo tuần 1 tháng 4/2025 - Lớp Năng Khiếu',
                'duong_dan' => 'baocao_tuan1_thang4_lopnangkhieu.pdf',
                'ngay_tao' => '2025-04-05 17:00:00',
                'ngay_ky' => '2025-04-06',
                'tinh_trang' => 1,
            ],
            [
                'id' => 10,
                'id_giao_vien' => 20,
                'id_nhan_vien' => 1,
                'loai_bao_cao' => 2,
                'tieu_de' => 'Báo cáo tháng 4/2025 - Lớp Đặc Biệt',
                'duong_dan' => 'baocao_thang4_lopdacbiet.pdf',
                'ngay_tao' => '2025-04-30 17:00:00',
                'ngay_ky' => '2025-05-01',
                'tinh_trang' => 1,
            ],
        ];

        DB::table('bao_caos')->insert($baoCaos);
    }
}
