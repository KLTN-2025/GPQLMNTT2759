<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichLamViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lich_lam_viecs')->delete();
        DB::table('lich_lam_viecs')->truncate();

        // Ca làm việc: 1 = Ca sáng, 2 = Ca chiều, 3 = Ca tối
        $data = [];

        // Lấy danh sách nhân viên đang hoạt động với id_chuc_vu
        $nhanViens = DB::table('nhan_viens')
            ->where('tinh_trang', 1)
            ->select('id', 'id_chuc_vu')
            ->get()
            ->groupBy('id_chuc_vu')
            ->toArray();

        // Lấy danh sách giáo viên đang hoạt động (tinh_trang = 1)
        $giaoViens = DB::table('giao_viens')
            ->where('tinh_trang', 1)
            ->pluck('id')
            ->toArray();

        // Tạo lịch làm việc cho 4 tuần tiếp theo (28 ngày)
        $startDate = Carbon::now()->startOfWeek(); // Bắt đầu từ đầu tuần hiện tại

        // Tạo lịch làm việc cho nhân viên theo từng chức vụ
        foreach ($nhanViens as $idChucVu => $nhanVienList) {
            $nhanVienIds = array_column($nhanVienList, 'id');

            // Xử lý đặc biệt cho Bảo vệ (id_chuc_vu = 7)
            if ($idChucVu == 7) {
                // Bảo vệ làm từ thứ 2 đến chủ nhật (7 ngày) và có thể làm 2 ca liên tục
                foreach ($nhanVienIds as $index => $idNhanVien) {
                    for ($week = 0; $week < 4; $week++) {
                        $weekStart = $startDate->copy()->addWeeks($week);

                        // Làm việc từ thứ 2 (1) đến chủ nhật (7)
                        for ($dayOfWeek = 1; $dayOfWeek <= 7; $dayOfWeek++) {
                            $ngayLamViec = $weekStart->copy()->addDays($dayOfWeek - 1);

                            // Bảo vệ có thể làm 1 ca hoặc 2 ca liên tục (không làm 3 ca liên tục)
                            $soCa = rand(1, 10) <= 2 ? 1 : 2; // 20% chỉ làm 1 ca, 80% làm 2 ca liên tục

                            if ($soCa == 2) {
                                // Làm 2 ca liên tục: ca 1+2 (sáng+chiều) hoặc ca 2+3 (chiều+tối)
                                // Xoay giữa các bảo vệ để phân bổ đều
                                $loaiCa = ($dayOfWeek + $index + $week) % 2; // 0 = ca 1+2, 1 = ca 2+3

                                if ($loaiCa == 0) {
                                    // Làm ca 1 và ca 2 (sáng + chiều)
                                    $data[] = [
                                        'id_nhan_vien' => $idNhanVien,
                                        'id_giao_vien' => null,
                                        'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                        'ca_lam_viec' => 1, // Ca sáng
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                    $data[] = [
                                        'id_nhan_vien' => $idNhanVien,
                                        'id_giao_vien' => null,
                                        'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                        'ca_lam_viec' => 2, // Ca chiều
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                } else {
                                    // Làm ca 2 và ca 3 (chiều + tối)
                                    $data[] = [
                                        'id_nhan_vien' => $idNhanVien,
                                        'id_giao_vien' => null,
                                        'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                        'ca_lam_viec' => 2, // Ca chiều
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                    $data[] = [
                                        'id_nhan_vien' => $idNhanVien,
                                        'id_giao_vien' => null,
                                        'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                        'ca_lam_viec' => 3, // Ca tối
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ];
                                }
                            } else {
                                // Chỉ làm 1 ca (xoay vòng giữa 3 ca)
                                $caIndex = ($dayOfWeek + $index + $week) % 3; // Xoay giữa 3 ca
                                $ca = $caIndex + 1; // 1, 2, hoặc 3
                                $data[] = [
                                    'id_nhan_vien' => $idNhanVien,
                                    'id_giao_vien' => null,
                                    'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                    'ca_lam_viec' => $ca,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }
                        }
                    }
                }
            } else {
                // Các chức vụ khác: làm việc 5-6 ngày/tuần (thứ 2 đến thứ 7)
                foreach ($nhanVienIds as $index => $idNhanVien) {
                    for ($week = 0; $week < 4; $week++) {
                        $weekStart = $startDate->copy()->addWeeks($week);

                        // Chọn ngẫu nhiên 5-6 ngày trong tuần (thứ 2 đến thứ 7)
                        $workingDays = collect(range(1, 6))->shuffle()->take(rand(5, 6));

                        foreach ($workingDays as $dayOfWeek) {
                            $ngayLamViec = $weekStart->copy()->addDays($dayOfWeek - 1);

                            // Bình thường làm cả 2 ca (sáng và chiều), đôi khi chỉ làm 1 ca
                            $soCa = rand(1, 10) <= 2 ? 1 : 2; // 20% chỉ làm 1 ca, 80% làm cả 2 ca

                            if ($soCa == 2) {
                                // Làm cả 2 ca: sáng và chiều
                                $data[] = [
                                    'id_nhan_vien' => $idNhanVien,
                                    'id_giao_vien' => null,
                                    'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                    'ca_lam_viec' => 1, // Ca sáng
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                                $data[] = [
                                    'id_nhan_vien' => $idNhanVien,
                                    'id_giao_vien' => null,
                                    'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                    'ca_lam_viec' => 2, // Ca chiều
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            } else {
                                // Chỉ làm 1 ca: sáng hoặc chiều (xoay vòng giữa các nhân viên cùng chức vụ)
                                $ca = (($dayOfWeek + $index + $week) % 2) + 1; // Xoay giữa ca 1 và ca 2
                                $data[] = [
                                    'id_nhan_vien' => $idNhanVien,
                                    'id_giao_vien' => null,
                                    'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                                    'ca_lam_viec' => $ca,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                            }
                        }
                    }
                }
            }
        }

        // Tạo lịch làm việc cho giáo viên
        foreach ($giaoViens as $index => $idGiaoVien) {
            // Giáo viên thường làm việc 5 ngày/tuần (thứ 2 đến thứ 6)
            for ($week = 0; $week < 4; $week++) {
                $weekStart = $startDate->copy()->addWeeks($week);

                // Giáo viên làm việc từ thứ 2 đến thứ 6
                for ($dayOfWeek = 1; $dayOfWeek <= 5; $dayOfWeek++) {
                    $ngayLamViec = $weekStart->copy()->addDays($dayOfWeek - 1);

                    // Bình thường làm cả 2 ca (sáng và chiều), đôi khi chỉ làm 1 ca
                    $soCa = rand(1, 10) <= 2 ? 1 : 2; // 20% chỉ làm 1 ca, 80% làm cả 2 ca

                    if ($soCa == 2) {
                        // Làm cả 2 ca: sáng và chiều
                        $data[] = [
                            'id_nhan_vien' => null,
                            'id_giao_vien' => $idGiaoVien,
                            'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                            'ca_lam_viec' => 1, // Ca sáng
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $data[] = [
                            'id_nhan_vien' => null,
                            'id_giao_vien' => $idGiaoVien,
                            'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                            'ca_lam_viec' => 2, // Ca chiều
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    } else {
                        // Chỉ làm 1 ca: sáng hoặc chiều (xoay vòng)
                        $ca = (($dayOfWeek + $index + $week) % 2) + 1; // Xoay giữa ca 1 và ca 2
                        $data[] = [
                            'id_nhan_vien' => null,
                            'id_giao_vien' => $idGiaoVien,
                            'ngay_lam_viec' => $ngayLamViec->format('Y-m-d'),
                            'ca_lam_viec' => $ca,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        // Chèn dữ liệu vào database
        DB::table('lich_lam_viecs')->insert($data);
    }
}
