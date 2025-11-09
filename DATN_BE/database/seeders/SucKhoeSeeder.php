<?php

namespace Database\Seeders;

use App\Models\SucKhoe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SucKhoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ và chuẩn hóa id tự tăng
        DB::table('suc_khoes')->delete();
        DB::table('suc_khoes')->truncate();

        // Chú thích giá trị:
        // thi_luc, rang_mieng: 1=Tốt, 2=Khá, 3=Trung bình, 4=Yếu
        // tinh_trang_suc_khoe: 1=Tốt, 2=Cần theo dõi, 3=Cần can thiệp
        // loai_kham: 1=Định kì, 0=Cấp cứu

        // Lấy tất cả học sinh từ database
        $hocSinhs = DB::table('hoc_sinhs')
            ->join('lop_hocs', 'hoc_sinhs.id_lop_hoc', '=', 'lop_hocs.id')
            ->select('hoc_sinhs.id', 'hoc_sinhs.ngay_sinh', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id_khoi_lop')
            ->get();

        $sucKhoes = [];
        $idCounter = 1;

        foreach ($hocSinhs as $hocSinh) {
            // Tính tuổi của học sinh
            $birthDate = Carbon::parse($hocSinh->ngay_sinh);
            $ageInMonths = $birthDate->diffInMonths(Carbon::now());
            $ageInYears = $ageInMonths / 12;

            // Xác định chiều cao và cân nặng chuẩn dựa trên độ tuổi
            $healthData = $this->getHealthDataByAge($ageInYears, $hocSinh->id_khoi_lop);

            // Tạo 2-3 lần khám cho mỗi học sinh
            $examCount = rand(2, 3);
            $baseDate = Carbon::now()->subMonths(3); // Bắt đầu từ 3 tháng trước

            for ($i = 0; $i < $examCount; $i++) {
                // Ngày khám cách nhau 2-4 tuần
                $daysOffset = $i * rand(14, 28);
                $examDate = $baseDate->copy()->addDays($daysOffset);

                // Chiều cao và cân nặng tăng dần theo thời gian
                $growthFactor = 1 + ($i * 0.02); // Tăng 2% mỗi lần khám
                $chieuCao = round($healthData['chieu_cao'] * $growthFactor + rand(-2, 2), 1);
                $canNang = round($healthData['can_nang'] * $growthFactor + rand(-0.5, 0.5), 1);

                // Đa dạng tình trạng sức khỏe (70% tốt, 25% cần theo dõi, 5% cần can thiệp)
                $randHealth = rand(1, 100);
                if ($randHealth <= 70) {
                    $tinhTrangSucKhoe = 1; // Tốt
                    $thiLuc = rand(1, 2); // Tốt hoặc Khá
                    $rangMieng = rand(1, 2); // Tốt hoặc Khá
                } elseif ($randHealth <= 95) {
                    $tinhTrangSucKhoe = 2; // Cần theo dõi
                    $thiLuc = rand(2, 3); // Khá hoặc Trung bình
                    $rangMieng = rand(2, 3); // Khá hoặc Trung bình
                } else {
                    $tinhTrangSucKhoe = 3; // Cần can thiệp
                    $thiLuc = rand(3, 4); // Trung bình hoặc Yếu
                    $rangMieng = rand(3, 4); // Trung bình hoặc Yếu
                }

                // Cải thiện tình trạng ở lần khám sau
                if ($i > 0 && $tinhTrangSucKhoe > 1) {
                    // 30% khả năng cải thiện
                    if (rand(1, 100) <= 30) {
                        $tinhTrangSucKhoe = max(1, $tinhTrangSucKhoe - 1);
                        $thiLuc = max(1, $thiLuc - 1);
                        $rangMieng = max(1, $rangMieng - 1);
                    }
                }

                // Ghi chú phù hợp với tình trạng
                $ghiChu = $this->generateGhiChu($tinhTrangSucKhoe, $thiLuc, $rangMieng, $chieuCao, $canNang, $ageInYears);

                // 95% là khám định kỳ, 5% là cấp cứu
                $loaiKham = (rand(1, 100) <= 95) ? 1 : 0;

                $sucKhoes[] = [
                    'id' => $idCounter++,
                    'id_hoc_sinh' => $hocSinh->id,
                    'ngay_kham' => $examDate->format('Y-m-d'),
                    'chieu_cao' => $chieuCao,
                    'can_nang' => $canNang,
                    'thi_luc' => $thiLuc,
                    'rang_mieng' => $rangMieng,
                    'tinh_trang_suc_khoe' => $tinhTrangSucKhoe,
                    'loai_kham' => $loaiKham,
                    'ghi_chu' => $ghiChu,
                ];
            }
        }

        // Chèn dữ liệu theo batch để tránh quá tải
        $chunks = array_chunk($sucKhoes, 500);
        foreach ($chunks as $chunk) {
            DB::table('suc_khoes')->insert($chunk);
        }
    }

    /**
     * Lấy dữ liệu chiều cao và cân nặng chuẩn dựa trên độ tuổi
     */
    private function getHealthDataByAge($ageInYears, $khoiLop)
    {
        // Dữ liệu tham khảo WHO cho trẻ em Việt Nam
        // Chiều cao (cm) và Cân nặng (kg) theo độ tuổi

        if ($ageInYears < 1.5) {
            // 12-18 tháng (Nhà trẻ nhỏ)
            return [
                'chieu_cao' => rand(75, 85),
                'can_nang' => rand(9, 12),
            ];
        } elseif ($ageInYears < 2.5) {
            // 18-30 tháng (Nhà trẻ lớn)
            return [
                'chieu_cao' => rand(85, 95),
                'can_nang' => rand(11, 14),
            ];
        } elseif ($ageInYears < 3.5) {
            // 2.5-3.5 tuổi (Mầm nhỏ)
            return [
                'chieu_cao' => rand(90, 100),
                'can_nang' => rand(12, 16),
            ];
        } elseif ($ageInYears < 4.5) {
            // 3.5-4.5 tuổi (Mầm lớn)
            return [
                'chieu_cao' => rand(100, 110),
                'can_nang' => rand(15, 19),
            ];
        } elseif ($ageInYears < 5.5) {
            // 4.5-5.5 tuổi (Chồi)
            return [
                'chieu_cao' => rand(105, 115),
                'can_nang' => rand(17, 22),
            ];
        } else {
            // 5.5-6.5 tuổi (Lá)
            return [
                'chieu_cao' => rand(110, 120),
                'can_nang' => rand(19, 25),
            ];
        }
    }

    /**
     * Tạo ghi chú phù hợp với tình trạng sức khỏe
     */
    private function generateGhiChu($tinhTrangSucKhoe, $thiLuc, $rangMieng, $chieuCao, $canNang, $ageInYears)
    {
        $ghichus = [];

        // Ghi chú chính về tình trạng sức khỏe (chọn ngẫu nhiên)
        if ($tinhTrangSucKhoe == 1) {
            $mainNotes = [
                'Sức khỏe tốt, phát triển bình thường.',
                'Đạt chuẩn phát triển theo độ tuổi.',
                'Tăng trưởng ổn định, không có vấn đề đáng lo ngại.',
                'Phát triển tốt, đạt các chỉ số chuẩn.',
            ];
            $ghichus[] = $mainNotes[array_rand($mainNotes)];
        } elseif ($tinhTrangSucKhoe == 2) {
            $mainNotes = [
                'Cần theo dõi thêm, tăng cường dinh dưỡng.',
                'Cần chú ý chế độ ăn và vận động.',
                'Theo dõi định kỳ để đảm bảo phát triển tốt.',
                'Cần điều chỉnh một số chỉ số sức khỏe.',
            ];
            $ghichus[] = $mainNotes[array_rand($mainNotes)];
        } else {
            $mainNotes = [
                'Cần can thiệp y tế, tư vấn chuyên khoa.',
                'Cần điều chỉnh chế độ dinh dưỡng và vận động ngay.',
                'Theo dõi sát sao và có biện pháp can thiệp kịp thời.',
                'Cần có biện pháp can thiệp y tế sớm.',
            ];
            $ghichus[] = $mainNotes[array_rand($mainNotes)];
        }

        // Ghi chú về thị lực
        if ($thiLuc >= 3) {
            $ghichus[] = 'Thị lực cần được kiểm tra định kỳ.';
        }

        // Ghi chú về răng miệng
        if ($rangMieng >= 3) {
            $ghichus[] = 'Cần chú ý vệ sinh răng miệng.';
        }

        // Ghi chú về chiều cao và cân nặng
        $bmi = $canNang / (($chieuCao / 100) * ($chieuCao / 100));
        if ($bmi < 13) {
            $ghichus[] = 'Cân nặng thấp so với chiều cao, cần tăng cường dinh dưỡng.';
        } elseif ($bmi > 20) {
            $ghichus[] = 'Cần chú ý chế độ ăn để tránh thừa cân.';
        }

        return implode(' ', $ghichus);
    }
}
