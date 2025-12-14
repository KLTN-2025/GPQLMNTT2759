<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use DisableForeignKeys;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt foreign key checks
        $this->disableForeignKeys();

        try {
            $this->call([
                // Clean up chat tables first
                ChatCleanupSeeder::class,

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
                MonAnBoSungSeeder::class, // Thêm món ăn đa dạng
                ThucDonSeeder::class,
                ChiTietThucDonSeeder::class,
                MenuThang12Seeder::class, // Menu tháng 12

                // Seeder quản lý
                HocPhiSeeder::class,
                HoaDonHocPhiSeeder::class,
                ChiTietHocPhiSeeder::class,
                PhanQuyenSeeder::class,
                LichLamViecSeeder::class,

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
        } finally {
            // Bật lại foreign key checks
            $this->enableForeignKeys();
        }
    }
}
