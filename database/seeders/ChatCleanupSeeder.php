<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatCleanupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Clean up chat-related tables before main seeders run
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate all chat-related tables
        DB::table('doc_tin_nhan_nhom')->truncate();
        DB::table('tin_nhan_nhom')->truncate();
        DB::table('nhom_chat_lop')->truncate();
        DB::table('tin_nhans')->truncate();
        DB::table('cuoc_tro_chuyen')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
