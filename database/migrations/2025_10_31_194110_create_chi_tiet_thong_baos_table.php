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
        Schema::create('chi_tiet_thong_baos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_thong_bao');
            $table->integer('id_phu_huynh');
            $table->integer('id_giao_vien');
            $table->integer('id_lop_hoc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_thong_baos');
    }
};
