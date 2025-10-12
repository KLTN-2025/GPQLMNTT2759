<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lop_hocs', function (Blueprint $table) {
            $table->id();
             $table->string('ten_lop')->unique();
            $table->integer('id_khoi_lop');
            $table->integer('id_nam_hoc');
            $table->integer('id_giao_vien');
            $table->integer('so_luong')->default(0)->comment('Số lượng học sinh tối đa trong lớp (tối đa 25)');
            $table->integer('is_block')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_hocs');
    }
};
