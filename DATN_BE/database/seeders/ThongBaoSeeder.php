<?php

namespace Database\Seeders;

use App\Models\ThongBao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThongBaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('thong_baos')->delete();
        DB::table('thong_baos')->truncate();

        $thongBaos = [
            [
                'id' => 1,
                'tieu_de' => 'Thông báo về lịch nghỉ Tết Nguyên Đán 2025',
                'noi_dung' => 'Trường mầm non thông báo lịch nghỉ Tết Nguyên Đán 2025 từ ngày 28/01/2025 đến hết ngày 05/02/2025. Các phụ huynh vui lòng chuẩn bị cho các con.',
                'hinh_anh' => 'https://i.pinimg.com/1200x/11/42/92/1142928983ca320ca15b8014cf28e0b6.jpg',
                'tep_dinh_kem' => null,
                'thoi_gian_dang' => '2025-01-15 08:00:00',
                'ngay_het_hieu_luc' => '2025-02-28',
                'tinh_trang' => 1,
                'id_nhan_vien' => 1,
                'loai_thong_bao' => 1, // Thông báo chung
            ],
            [
                'id' => 2,
                'tieu_de' => 'Thông báo đóng học phí tháng 1/2025',
                'noi_dung' => 'Trường thông báo đến các phụ huynh về việc đóng học phí tháng 1/2025. Thời hạn đóng từ ngày 01/01/2025 đến 10/01/2025.',
                'hinh_anh' => null,
                'tep_dinh_kem' => 'https://xdcs.cdnchinhphu.vn/446259493575335936/2025/2/28/vnapotalbochinhtriquyetdinhmienhocphichohocsinhtumamnondenhettrunghocphothongconglap-1740746444632646541564.jpg',
                'thoi_gian_dang' => '2024-12-28 10:00:00',
                'ngay_het_hieu_luc' => '2025-01-31',
                'tinh_trang' => 1,
                'id_nhan_vien' => 2,
                'loai_thong_bao' => 2, // Thông báo học phí
            ],
            [
                'id' => 3,
                'tieu_de' => 'Hoạt động ngoại khóa tháng 2/2025',
                'noi_dung' => 'Trường tổ chức hoạt động ngoại khóa "Ngày hội thể thao" vào ngày 15/02/2025. Mời các phụ huynh tham gia cổ vũ cho các con.',
                'hinh_anh' => 'https://i.pinimg.com/736x/0b/ba/e2/0bbae248da35eda307d59b78b87e42b2.jpg',
                'tep_dinh_kem' => null,
                'thoi_gian_dang' => '2025-02-01 09:00:00',
                'ngay_het_hieu_luc' => '2025-02-28',
                'tinh_trang' => 1,
                'id_nhan_vien' => 1,
                'loai_thong_bao' => 3, // Thông báo hoạt động
            ],
            [
                'id' => 4,
                'tieu_de' => 'Thông báo về thực đơn mới',
                'noi_dung' => 'Nhà trường thông báo thực đơn mới cho tháng 2/2025, đảm bảo dinh dưỡng và an toàn thực phẩm cho các con.',
                'hinh_anh' => 'https://i.pinimg.com/736x/1b/4f/61/1b4f61cdb1e3c9fe05bb504256ece809.jpg',
                'tep_dinh_kem' => 'thucdon_thang2.pdf',
                'thoi_gian_dang' => '2025-01-25 14:00:00',
                'ngay_het_hieu_luc' => '2025-02-28',
                'tinh_trang' => 1,
                'id_nhan_vien' => 2,
                'loai_thong_bao' => 1,
            ],
            [
                'id' => 5,
                'tieu_de' => 'Thông báo kiểm tra sức khỏe định kỳ',
                'noi_dung' => 'Nhà trường tổ chức kiểm tra sức khỏe định kỳ cho học sinh vào ngày 20/02/2025. Phụ huynh vui lòng cho con đi học đúng giờ.',
                'hinh_anh' => 'https://i.pinimg.com/736x/02/69/cd/0269cdb09c593e31b3308b9327f5ac9e.jpg',
                'tep_dinh_kem' => null,
                'thoi_gian_dang' => '2025-02-10 08:30:00',
                'ngay_het_hieu_luc' => '2025-02-28',
                'tinh_trang' => 1,
                'id_nhan_vien' => 3,
                'loai_thong_bao' => 4, // Thông báo y tế
            ],
            [
                'id' => 6,
                'tieu_de' => 'Thông báo về chương trình học mới',
                'noi_dung' => 'Nhà trường triển khai chương trình học mới từ tháng 3/2025, với nhiều hoạt động bổ ích và phù hợp với độ tuổi các con.',
                'hinh_anh' => 'https://i.pinimg.com/736x/a4/d2/3f/a4d23fdd09b48a21efa39285e29fcd02.jpg',
                'tep_dinh_kem' => 'chuongtrinh_hoc_moi.pdf',
                'thoi_gian_dang' => '2025-02-20 10:00:00',
                'ngay_het_hieu_luc' => '2025-03-31',
                'tinh_trang' => 1,
                'id_nhan_vien' => 1,
                'loai_thong_bao' => 1,
            ],
            [
                'id' => 7,
                'tieu_de' => 'Thông báo đóng học phí tháng 3/2025',
                'noi_dung' => 'Trường thông báo đến các phụ huynh về việc đóng học phí tháng 3/2025. Thời hạn đóng từ ngày 01/03/2025 đến 10/03/2025.',
                'hinh_anh' => 'https://xdcs.cdnchinhphu.vn/446259493575335936/2025/2/28/vnapotalbochinhtriquyetdinhmienhocphichohocsinhtumamnondenhettrunghocphothongconglap-1740746444632646541564.jpg',
                'tep_dinh_kem' => 'hocphi_thang3.pdf',
                'thoi_gian_dang' => '2025-02-25 10:00:00',
                'ngay_het_hieu_luc' => '2025-03-31',
                'tinh_trang' => 1,
                'id_nhan_vien' => 2,
                'loai_thong_bao' => 2,
            ],
            [
                'id' => 8,
                'tieu_de' => 'Thông báo họp phụ huynh học sinh',
                'noi_dung' => 'Nhà trường tổ chức họp phụ huynh học sinh vào ngày 25/03/2025 để báo cáo tình hình học tập của các con trong học kỳ.',
                'hinh_anh' => null,
                'tep_dinh_kem' => 'lich_hop_phuhuynh.pdf',
                'thoi_gian_dang' => '2025-03-15 09:00:00',
                'ngay_het_hieu_luc' => '2025-03-31',
                'tinh_trang' => 1,
                'id_nhan_vien' => 1,
                'loai_thong_bao' => 1,
            ],
        ];

        DB::table('thong_baos')->insert($thongBaos);
    }
}
