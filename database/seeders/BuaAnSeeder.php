<?php

namespace Database\Seeders;

use App\Models\BuaAn;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuaAnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('bua_ans')->delete();
        DB::table('bua_ans')->truncate();

        $buaAns = [
            [
                'id' => 1,
                'ten_bua_an' => 'Bữa sáng',
                'mo_ta' => 'Bữa ăn sáng cho trẻ',

            ],
            [
                'id' => 2,
                'ten_bua_an' => 'Bữa phụ sáng',
                'mo_ta' => 'Bữa ăn phụ buổi sáng (sữa, bánh)',

            ],
            [
                'id' => 3,
                'ten_bua_an' => 'Bữa trưa',
                'mo_ta' => 'Bữa ăn chính buổi trưa',

            ],
            [
                'id' => 4,
                'ten_bua_an' => 'Bữa phụ chiều',
                'mo_ta' => 'Bữa ăn phụ buổi chiều (sữa, trái cây)',

            ],
            [
                'id' => 5,
                'ten_bua_an' => 'Bữa chiều',
                'mo_ta' => 'Bữa ăn chính buổi chiều',

            ],
        ];

        DB::table('bua_ans')->insert($buaAns);
    }
}
