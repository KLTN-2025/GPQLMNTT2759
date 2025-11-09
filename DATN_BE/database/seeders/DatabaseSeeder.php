<?php

namespace Database\Seeders;

use App\Models\HocSinh;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            // Seeder cơ bản
            ChucVuSeeder::class,
            KhoiLopSeeder::class,
            NamHocSeeder::class,
            ChucNangSeeder::class,

            // Seeder dữ liệu chính
            NhanVienSeeder::class,
            GiaoVienSeeder::class,
            PhuHuynhSeeder::class,
            LopHocSeeder::class,
            HocSinhSeeder::class,

            // Seeder dữ liệu bổ sung
            BuaAnSeeder::class,
            MonAnSeeder::class,
            ThucDonSeeder::class,
            ChiTietThucDonSeeder::class,

            // Seeder quản lý
            HocPhiSeeder::class,
            HoaDonHocPhiSeeder::class,
            ChiTietHocPhiSeeder::class,
            PhanQuyenSeeder::class,

            // Seeder nội dung
            LoaiBaiVietSeeder::class,
            BaiVietSeeder::class,
            ThongBaoSeeder::class,
            ChiTietThongBaoSeeder::class,
            BaoCaoSeeder::class,

            // Seeder theo dõi
            DiemDanhSeeder::class,
            SucKhoeSeeder::class,
            NhanXetSeeder::class,
            BinhLuanSeeder::class,
        ]);
    }
}
