<?php

namespace Database\Seeders;

use App\Models\HoaDonHocPhi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoaDonHocPhiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hoa_don_hoc_phis')->delete();
        DB::table('hoa_don_hoc_phis')->truncate();

        // Lấy danh sách học sinh và lớp học
        $hocSinhs = DB::table('hoc_sinhs')->get();

        if ($hocSinhs->isEmpty()) {
            return;
        }

        $hoaDonHocPhis = [];
        $hoaDonId = 1;

        // Tạo hóa đơn cho mỗi học sinh với các tháng từ 1/2025 đến 3/2025
        $months = [
            ['month' => '01', 'year' => '2025', 'name' => 'Tháng 1/2025'],
            ['month' => '02', 'year' => '2025', 'name' => 'Tháng 2/2025'],
            ['month' => '03', 'year' => '2025', 'name' => 'Tháng 3/2025'],
        ];

        foreach ($hocSinhs as $hocSinh) {
            foreach ($months as $monthInfo) {
                // Tính tổng tiền dựa trên các loại phí (sẽ được tính trong ChiTietHocPhi)
                // Tạm tính: Học phí + Phí ăn trưa = 2.000.000
                $tongTien = 2000000.00;

                // 70% đã thanh toán, 30% chưa thanh toán
                $daThanhToan = (rand(1, 10) <= 7) ? $tongTien : rand(0, (int)($tongTien * 0.9));
                $conNo = $tongTien - $daThanhToan;

                $tinhTrang = ($conNo == 0) ? 1 : 0; // 1: Đã thanh toán, 0: Chưa thanh toán

                // ngay_tao: Ngày tạo hóa đơn (đầu tháng, ngày 1-5)
                $ngayTaoDay = rand(1, 5);
                $ngayTao = sprintf('%s-%s-%02d', $monthInfo['year'], $monthInfo['month'], $ngayTaoDay);

                // ngay_thanh_toan: Ngày thanh toán
                // Nếu đã thanh toán: từ ngày tạo đến ngày 15 trong tháng (đảm bảo >= ngày tạo)
                // Nếu chưa thanh toán: để bằng ngày tạo (do migration không cho phép null)
                if ($tinhTrang == 1) {
                    // Đã thanh toán: ngày thanh toán từ ngày tạo đến ngày 15
                    $ngayThanhToanDay = rand($ngayTaoDay, 15);
                    $ngayThanhToan = sprintf('%s-%s-%02d', $monthInfo['year'], $monthInfo['month'], $ngayThanhToanDay);
                } else {
                    // Chưa thanh toán: để bằng ngày tạo (sẽ được cập nhật khi thanh toán)
                    $ngayThanhToan = $ngayTao;
                }

                // Chọn nhân viên ngẫu nhiên từ 1-10
                $nhanVienId = rand(1, 10);

                $hoaDonHocPhis[] = [
                    'id' => $hoaDonId,
                    'id_hoc_sinh' => $hocSinh->id,
                    'id_lop' => $hocSinh->id_lop_hoc,
                    'hoc_phi_thang_nam' => $monthInfo['name'],
                    'tong_tien' => $tongTien,
                    'da_thanh_toan' => $daThanhToan,
                    'con_no' => $conNo,
                    'tinh_trang' => $tinhTrang,
                    'ngay_tao' => $ngayTao,
                    'ngay_thanh_toan' => $ngayThanhToan,
                    'id_nhan_vien' => $nhanVienId,
                ];

                $hoaDonId++;
            }
        }

        DB::table('hoa_don_hoc_phis')->insert($hoaDonHocPhis);
    }
}
