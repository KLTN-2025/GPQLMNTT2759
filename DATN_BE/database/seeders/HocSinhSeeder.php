<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HocSinhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hoc_sinhs')->delete();
        DB::table('hoc_sinhs')->truncate();

        $lastNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Đặng', 'Vũ', 'Ngô', 'Trịnh', 'Lương', 'Phan', 'Bùi', 'Đỗ', 'Hà', 'Đinh', 'Trương', 'Tạ', 'Phùng', 'Lý'];
        $middleNames = ['Văn', 'Thị'];
        $firstNames = [
            'An',
            'Bích',
            'Châu',
            'Dung',
            'Đạt',
            'Hồng',
            'Quân',
            'Lan',
            'Hùng',
            'Mai',
            'Lâm',
            'Mơ',
            'Nam',
            'Ngọc',
            'Phúc',
            'Quỳnh',
            'Sơn',
            'Thanh',
            'Thắng',
            'Thảo',
            'Toàn',
            'Trang',
            'Tuấn',
            'Vân',
            'Việt',
            'Yến',
            'Bình',
            'Cúc',
            'Dũng',
            'Giang',
            'Hiếu',
            'Hòa',
            'Huy',
            'Hương',
            'Khánh',
            'Kim',
            'Long',
            'Loan',
            'Lộc',
            'Mạnh',
            'Nga',
            'Phong',
            'Quý',
            'Quyên',
            'Thắm',
            'Thành',
            'Thu',
            'Bảo',
            'Cường',
            'Dương',
            'Đức',
            'Hạnh',
            'Hoa',
            'Khang',
            'Linh',
            'Minh',
            'Oanh',
            'Phương',
            'Quang',
            'Sinh',
            'Tâm',
            'Uyên',
            'Vinh',
            'Xuân',
            'Yên',
            'Chi',
            'Đan',
            'Em',
            'Gia',
            'Hân'
        ];

        $students = [];
        $cities = ['Hà Nội', 'TP HCM', 'Đà Nẵng', 'Cần Thơ', 'Hải Phòng', 'Bắc Ninh', 'Nam Định', 'Quảng Ninh', 'Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Thái Bình'];

        // Tạo danh sách lớp học (20 lớp)
        $classIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $classIds[] = $i;
        }

        // Tạo danh sách phụ huynh (250 phụ huynh cho 500 học sinh)
        $parentIds = [];
        for ($i = 1; $i <= 250; $i++) {
            $parentIds[] = $i;
        }

        $studentId = 1;
        $parentIndex = 0;
        $studentsPerParent = [2, 2, 3]; // Mỗi phụ huynh có 2-3 học sinh
        $currentParentStudentCount = 0;
        $currentParentId = $parentIds[$parentIndex];

        // Tạo học sinh cho từng lớp với độ tuổi phù hợp
        foreach ($classIds as $classId) {
            $studentsInClass = 25; // 25 học sinh mỗi lớp (tăng từ 20 lên 25)

            // Xác định khối lớp và độ tuổi tương ứng
            $khoiLop = $this->getKhoiLopByClassId($classId);
            $birthYearRange = $this->getBirthYearRangeByKhoiLop($khoiLop);

            for ($j = 0; $j < $studentsInClass; $j++) {
                $lastName = $lastNames[array_rand($lastNames)];
                $middleName = $middleNames[array_rand($middleNames)];
                $firstName = $firstNames[array_rand($firstNames)];
                $fullName = $lastName . ' ' . $middleName . ' ' . $firstName;
                $gender = ($middleName === 'Văn') ? 1 : 0; // Nam = 1, Nữ = 0

                // Phân bổ phụ huynh: mỗi phụ huynh có 2-3 học sinh
                if ($currentParentStudentCount >= $studentsPerParent[array_rand($studentsPerParent)]) {
                    $parentIndex++;
                    if ($parentIndex >= count($parentIds)) {
                        $parentIndex = 0; // Quay lại phụ huynh đầu nếu hết
                    }
                    $currentParentId = $parentIds[$parentIndex];
                    $currentParentStudentCount = 0;
                }

                $currentParentStudentCount++;

                // Tình trạng học sinh đa dạng (90% hoạt động, 10% không hoạt động)
                $status = (rand(1, 10) <= 9) ? 1 : 0;

                // Một số học sinh bị block (5%)
                $isBlock = (rand(1, 20) == 1) ? 1 : 0;

                // Ngày sinh phù hợp với khối lớp
                $birthYear = rand($birthYearRange['min'], $birthYearRange['max']);
                $birthMonth = rand(1, 12);
                $birthDay = rand(1, 28);
                $birthDate = sprintf('%04d-%02d-%02d', $birthYear, $birthMonth, $birthDay);

                $students[] = [
                    'id' => $studentId,
                    'ho_va_ten' => $fullName,
                    'gioi_tinh' => $gender,
                    'avatar' => "avatar$studentId.jpg",
                    'ngay_sinh' => $birthDate,
                    'dia_chi' => $cities[array_rand($cities)],
                    'tinh_trang' => $status,
                    'id_lop_hoc' => $classId,
                    'id_phu_huynh' => $currentParentId, // Đảm bảo mỗi học sinh có phụ huynh
                    'is_block' => $isBlock,
                ];

                $studentId++;
            }
        }

        DB::table('hoc_sinhs')->insert($students);
    }

    /**
     * Xác định khối lớp dựa trên ID lớp học
     */
    private function getKhoiLopByClassId($classId)
    {
        // Dựa trên LopHocSeeder thực tế:
        // Lớp 1-5: Khối 1 (Nhà trẻ) - id_khoi_lop = 1
        // Lớp 6-10: Khối 2 (Mầm) - id_khoi_lop = 2
        // Lớp 11-15: Khối 3 (Chồi) - id_khoi_lop = 3
        // Lớp 16-20: Khối 4 (Lá) - id_khoi_lop = 4

        if ($classId >= 1 && $classId <= 5) {
            return 1; // Nhà trẻ (18-36 tháng)
        } elseif ($classId >= 6 && $classId <= 10) {
            return 2; // Mầm (3-4 tuổi)
        } elseif ($classId >= 11 && $classId <= 15) {
            return 3; // Chồi (4-5 tuổi)
        } else {
            return 4; // Lá (5-6 tuổi)
        }
    }

    /**
     * Lấy khoảng năm sinh dựa trên khối lớp
     */
    private function getBirthYearRangeByKhoiLop($khoiLop)
    {
        $currentYear = date('Y');

        switch ($khoiLop) {
            case 1: // Nhà trẻ (18-36 tháng = 1.5-3 tuổi)
                return [
                    'min' => $currentYear - 3, // 3 tuổi (sinh năm 2021)
                    'max' => $currentYear - 1  // 1 tuổi (sinh năm 2023)
                ];
            case 2: // Mầm (3-4 tuổi)
                return [
                    'min' => $currentYear - 4, // 4 tuổi (sinh năm 2020)
                    'max' => $currentYear - 3  // 3 tuổi (sinh năm 2021)
                ];
            case 3: // Chồi (4-5 tuổi)
                return [
                    'min' => $currentYear - 5, // 5 tuổi (sinh năm 2019)
                    'max' => $currentYear - 4  // 4 tuổi (sinh năm 2020)
                ];
            case 4: // Lá (5-6 tuổi)
                return [
                    'min' => $currentYear - 6, // 6 tuổi (sinh năm 2018)
                    'max' => $currentYear - 5  // 5 tuổi (sinh năm 2019)
                ];
            default:
                return [
                    'min' => $currentYear - 4,
                    'max' => $currentYear - 3
                ];
        }
    }
}
