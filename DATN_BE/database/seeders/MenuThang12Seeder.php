<?php

namespace Database\Seeders;

use App\Models\ThucDon;
use App\Models\MonAn;
use App\Models\ChiTietThucDon;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuThang12Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách món ăn mẫu (ID từ MonAnSeeder)
        $monAnSang = [1, 2, 3, 10]; // Cháo gà, Bánh mì sữa, Phở bò, Bánh cuốn
        $monAnTrua = [4, 5, 6, 9];  // Cơm gà kho, Canh chua cá, Rau xanh luộc, Bún chả
        $monAnChieu = [7, 8];       // Chè đậu xanh, Sữa tươi

        // Tạo thực đơn từ 11/12 đến 31/12/2025
        $startDate = Carbon::create(2025, 12, 11);
        $endDate = Carbon::create(2025, 12, 31);

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            // Chỉ tạo menu cho thứ 2-6
            if ($currentDate->isWeekday()) {

                // Bữa sáng
                $thucDonSang = ThucDon::create([
                    'ten_thuc_don' => 'Thực đơn sáng - ' . $currentDate->format('d/m/Y'),
                    'ngay' => $currentDate->format('Y-m-d'),
                    'mo_ta' => 'Thực đơn bữa sáng ngày ' . $currentDate->format('d/m/Y'),
                ]);

                // Random 2 món ăn sáng
                $selectedSang = collect($monAnSang)->random(2);
                foreach ($selectedSang as $idMonAn) {
                    ChiTietThucDon::create([
                        'id_thuc_don' => $thucDonSang->id,
                        'id_mon_an' => $idMonAn,
                        'id_bua_an' => 1, // Bữa sáng
                        'so_luong' => 1,
                    ]);
                }

                // Bữa trưa
                $thucDonTrua = ThucDon::create([
                    'ten_thuc_don' => 'Thực đơn trưa - ' . $currentDate->format('d/m/Y'),
                    'ngay' => $currentDate->format('Y-m-d'),
                    'mo_ta' => 'Thực đơn bữa trưa ngày ' . $currentDate->format('d/m/Y'),
                ]);

                // Random 3 món ăn trưa
                $selectedTrua = collect($monAnTrua)->random(3);
                foreach ($selectedTrua as $idMonAn) {
                    ChiTietThucDon::create([
                        'id_thuc_don' => $thucDonTrua->id,
                        'id_mon_an' => $idMonAn,
                        'id_bua_an' => 3, // Bữa trưa
                        'so_luong' => 1,
                    ]);
                }

                // Bữa chiều
                $thucDonChieu = ThucDon::create([
                    'ten_thuc_don' => 'Thực đơn chiều - ' . $currentDate->format('d/m/Y'),
                    'ngay' => $currentDate->format('Y-m-d'),
                    'mo_ta' => 'Thực đơn bữa chiều ngày ' . $currentDate->format('d/m/Y'),
                ]);

                // Lấy 2 món ăn chiều
                foreach ($monAnChieu as $idMonAn) {
                    ChiTietThucDon::create([
                        'id_thuc_don' => $thucDonChieu->id,
                        'id_mon_an' => $idMonAn,
                        'id_bua_an' => 5, // Bữa chiều
                        'so_luong' => 1,
                    ]);
                }
            }

            $currentDate->addDay();
        }

        $this->command->info('Đã tạo thực đơn từ 11/12 đến 31/12/2025');
    }
}
