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
        Schema::create('bao_caos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_giao_vien');
            $table->integer('id_nhan_vien');
            $table->integer('loai_bao_cao');
            $table->string('tieu_de');
            $table->string('duong_dan');
            $table->datetime('ngay_tao');
            $table->date('ngay_ky');
            $table->integer('tinh_trang')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bao_caos');
    }
};
