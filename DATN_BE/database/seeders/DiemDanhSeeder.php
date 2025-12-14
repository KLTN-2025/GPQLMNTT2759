<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiemDanhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('diem_danhs')->delete();
        DB::table('diem_danhs')->truncate();

        $diemDanhs = [];
        $ghiChuCoMat = [
            'Đi học đầy đủ',
            'Đi học đúng giờ',
            'Học tập tốt',
            'Tích cực tham gia',
            'Chăm chỉ học tập',
        ];

        $ghiChuVang = [
            'Bị ốm, phụ huynh đã xin phép',
            'Gia đình có việc',
            'Bị sốt, phụ huynh đã xin phép',
            'Đi khám sức khỏe',
            'Gia đình đi du lịch',
            'Nghỉ phép',
            'Vắng mặt có phép',
        ];

        // Tạo điểm danh cho 10 ngày gần đây (từ 10 ngày trước đến hôm nay)
        $today = Carbon::now();
        $daysToGenerate = 10;

        // 20 lớp học, mỗi lớp có 25 học sinh
        // Học sinh id: Lớp 1 = 1-25, Lớp 2 = 26-50, ..., Lớp 20 = 476-500
        $studentsPerClass = 25;

        for ($dayOffset = $daysToGenerate; $dayOffset >= 0; $dayOffset--) {
            $ngayDiemDanh = $today->copy()->subDays($dayOffset)->format('Y-m-d');

            // Bỏ qua thứ 7 và chủ nhật (chỉ điểm danh thứ 2-6)
            $dayOfWeek = Carbon::parse($ngayDiemDanh)->dayOfWeek;
            if ($dayOfWeek == Carbon::SATURDAY || $dayOfWeek == Carbon::SUNDAY) {
                continue;
            }

            // Điểm danh cho tất cả lớp học (20 lớp)
            for ($lopId = 1; $lopId <= 20; $lopId++) {
                // Tính ID học sinh đầu tiên của lớp này
                $firstStudentId = (($lopId - 1) * $studentsPerClass) + 1;

                // Điểm danh cho tất cả học sinh trong lớp
                for ($studentIndex = 0; $studentIndex < $studentsPerClass; $studentIndex++) {
                    $studentId = $firstStudentId + $studentIndex;

                    // 85% học sinh có mặt, 15% vắng mặt (tỷ lệ thực tế)
                    $isPresent = rand(1, 100) <= 85;

                    $diemDanhs[] = [
                        'id_lop_hoc' => $lopId,
                        'id_hoc_sinh' => $studentId,
                        'ngay_diem_danh' => $ngayDiemDanh,
                        'tinh_trang' => $isPresent ? 1 : 0, // 1 = có mặt, 0 = vắng mặt
                        'ghi_chu' => $isPresent
                            ? $ghiChuCoMat[array_rand($ghiChuCoMat)]
                            : $ghiChuVang[array_rand($ghiChuVang)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Chèn dữ liệu theo batch để tránh memory limit
        $chunks = array_chunk($diemDanhs, 500);
        foreach ($chunks as $chunk) {
            DB::table('diem_danhs')->insert($chunk);
        }
    }
}
