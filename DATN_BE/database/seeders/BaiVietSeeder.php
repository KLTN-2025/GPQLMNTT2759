<?php

namespace Database\Seeders;

use App\Models\BaiViet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiVietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('bai_viets')->delete();
        DB::table('bai_viets')->truncate();

        $baiViets = [
            [
                'id' => 1,
                'tieu_de' => 'Thông báo về lịch nghỉ Tết Nguyên Đán 2025',
                'slug_tieu_de' => 'thong-bao-lich-nghi-tet-nguyen-dan-2025',
                'noi_dung' => 'Trường mầm non xin thông báo lịch nghỉ Tết Nguyên Đán 2025 từ ngày 20/01/2025 đến hết ngày 02/02/2025. Các em học sinh sẽ trở lại trường vào ngày 03/02/2025.',
                'hinh_anh' => 'https://i.pinimg.com/736x/8e/a0/61/8ea061948bb64ab137ac62d70de97ef0.jpg',
                'ngay_dang' => '2025-01-15 08:00:00',
                'luot_xem' => 0,
                'tinh_trang' => true,
                'id_nhan_vien' => 1,
                'id_loai_bai_viet' => 1, // Thông báo
            ],
            [
                'id' => 2,
                'tieu_de' => 'Hoạt động ngoại khóa: Tham quan vườn thú',
                'slug_tieu_de' => 'hoat-dong-ngoai-khoa-tham-quan-vuon-thu',
                'noi_dung' => 'Vào ngày 15/01/2025, các em học sinh khối Lá sẽ được tham quan vườn thú Thủ Lệ để tìm hiểu về các loài động vật và môi trường sống của chúng.',
                'hinh_anh' => 'https://i.pinimg.com/736x/0c/de/62/0cde627a1dc3efec3f8584e273143795.jpg',
                'ngay_dang' => '2025-01-10 09:00:00',
                'luot_xem' => 0,
                'tinh_trang' => true,
                'id_nhan_vien' => 1,
                'id_loai_bai_viet' => 5, // Hoạt động
            ],
            [
                'id' => 3,
                'tieu_de' => 'Kiến thức: Dinh dưỡng cho trẻ mầm non',
                'slug_tieu_de' => 'kien-thuc-dinh-duong-cho-tre-mam-non',
                'noi_dung' => 'Bài viết cung cấp thông tin về chế độ dinh dưỡng phù hợp cho trẻ ở độ tuổi mầm non, giúp phụ huynh hiểu rõ hơn về nhu cầu dinh dưỡng của con em mình.',
                'hinh_anh' => 'https://i.pinimg.com/736x/02/69/cd/0269cdb09c593e31b3308b9327f5ac9e.jpg',
                'ngay_dang' => '2025-01-08 10:00:00',
                'luot_xem' => 0,
                'tinh_trang' => true,
                'id_nhan_vien' => 1,
                'id_loai_bai_viet' => 4, // Kiến thức
            ],
            [
                'id' => 4,
                'tieu_de' => 'Sự kiện: Lễ hội mùa xuân 2025',
                'slug_tieu_de' => 'su-kien-le-hoi-mua-xuan-2025',
                'noi_dung' => 'Trường mầm non sẽ tổ chức lễ hội mùa xuân vào ngày 10/01/2025 với nhiều hoạt động vui nhộn như múa hát, vẽ tranh, làm đồ thủ công.',
                'hinh_anh' => 'https://i.pinimg.com/1200x/bb/1c/45/bb1c45ae0fac342132252ba7ccd35786.jpg',
                'ngay_dang' => '2025-01-05 11:00:00',
                'luot_xem' => 0,
                'tinh_trang' => true,
                'id_nhan_vien' => 1,
                'id_loai_bai_viet' => 3, // Sự kiện
            ],
        ];

        DB::table('bai_viets')->insert($baiViets);
    }
}
