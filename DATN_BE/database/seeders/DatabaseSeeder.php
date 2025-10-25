<?php

namespace Database\Seeders;

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
            PhuHuynhSeeder::class,
            LopHocSeeder::class,

            // Seeder dữ liệu bổ sung
            ThucDonSeeder::class,

            // Seeder quản lý
            PhanQuyenSeeder::class,

            // Seeder nội dung
            BaiVietSeeder::class,

            // Seeder theo dõi
            DiemDanhSeeder::class,
            SucKhoeSeeder::class,
        ]);
    }
}
