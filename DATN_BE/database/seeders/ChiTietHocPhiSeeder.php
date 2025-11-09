<?php

namespace Database\Seeders;

use App\Models\ChiTietHocPhi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietHocPhiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chi_tiet_hoc_phis')->delete();
        DB::table('chi_tiet_hoc_phis')->truncate();

        // Lấy danh sách hóa đơn học phí đã có
        $hoaDonIds = DB::table('hoa_don_hoc_phis')->pluck('id')->toArray();

        if (empty($hoaDonIds)) {
            // Nếu chưa có hóa đơn, không tạo chi tiết
            return;
        }

        $chiTietHocPhis = [];

        // Mỗi hóa đơn có từ 2-5 loại phí
        foreach ($hoaDonIds as $hoaDonId) {
            // Tất cả hóa đơn đều có học phí mầm non
            $hocPhiId = 1; // Học phí mầm non
            $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
            $soLuong = 1;
            $donGia = $hocPhi->don_gia;
            $thanhTien = $soLuong * $donGia;

            $chiTietHocPhis[] = [
                'id_hoa_don_hoc_phi' => $hoaDonId,
                'id_hoc_phi' => $hocPhiId,
                'so_luong' => $soLuong,
                'don_gia' => $donGia,
                'thanh_tien' => $thanhTien,
                'ghi_chu' => 'Học phí cơ bản',
            ];

            // Phí ăn sáng (90% hóa đơn có)
            if (rand(1, 10) <= 9) {
                $hocPhiId = 2; // Phí ăn sáng
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = 1;
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí ăn sáng tháng',
                ];
            }

            // Phí ăn trưa (95% hóa đơn có)
            if (rand(1, 20) <= 19) {
                $hocPhiId = 3; // Phí ăn trưa
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = 1;
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí ăn trưa tháng',
                ];
            }

            // Phí bán trú (70% hóa đơn có)
            if (rand(1, 10) <= 7) {
                $hocPhiId = 4; // Phí bán trú
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = 1;
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí bán trú tháng',
                ];
            }

            // Phí đồ dùng học tập (chỉ một số hóa đơn có - 30%)
            if (rand(1, 10) <= 3) {
                $hocPhiId = 5; // Phí đồ dùng học tập
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = 1;
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí đồ dùng học tập năm học',
                ];
            }

            // Phí đồng phục (chỉ một số hóa đơn có - 20%)
            if (rand(1, 10) <= 2) {
                $hocPhiId = 6; // Phí đồng phục
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = rand(1, 2); // 1-2 bộ
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí đồng phục',
                ];
            }

            // Phí ngoại khóa (50% hóa đơn có)
            if (rand(1, 10) <= 5) {
                $hocPhiId = 7; // Phí ngoại khóa
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = 1;
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí ngoại khóa tháng',
                ];
            }

            // Phí y tế (80% hóa đơn có)
            if (rand(1, 10) <= 8) {
                $hocPhiId = 8; // Phí y tế
                $hocPhi = DB::table('hoc_phis')->where('id', $hocPhiId)->first();
                $soLuong = 1;
                $donGia = $hocPhi->don_gia;
                $thanhTien = $soLuong * $donGia;

                $chiTietHocPhis[] = [
                    'id_hoa_don_hoc_phi' => $hoaDonId,
                    'id_hoc_phi' => $hocPhiId,
                    'so_luong' => $soLuong,
                    'don_gia' => $donGia,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => 'Phí y tế tháng',
                ];
            }
        }

        DB::table('chi_tiet_hoc_phis')->insert($chiTietHocPhis);

        // Sau khi tạo chi tiết, cập nhật lại tổng tiền của hóa đơn
        $hoaDons = DB::table('hoa_don_hoc_phis')->get();

        foreach ($hoaDons as $hoaDon) {
            $tongTienChiTiet = DB::table('chi_tiet_hoc_phis')
                ->where('id_hoa_don_hoc_phi', $hoaDon->id)
                ->sum('thanh_tien');

            if ($tongTienChiTiet > 0) {
                // Cập nhật lại tổng tiền, đã thanh toán và còn nợ
                $daThanhToan = $hoaDon->da_thanh_toan;
                if ($daThanhToan > $tongTienChiTiet) {
                    $daThanhToan = $tongTienChiTiet;
                }
                $conNo = $tongTienChiTiet - $daThanhToan;
                $tinhTrang = ($conNo == 0) ? 1 : 0;

                DB::table('hoa_don_hoc_phis')
                    ->where('id', $hoaDon->id)
                    ->update([
                        'tong_tien' => $tongTienChiTiet,
                        'da_thanh_toan' => $daThanhToan,
                        'con_no' => $conNo,
                        'tinh_trang' => $tinhTrang,
                    ]);
            }
        }
    }
}
