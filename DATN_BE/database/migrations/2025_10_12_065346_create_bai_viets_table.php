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
        Schema::create('bai_viets', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de')->unique();
            $table->string('slug_tieu_de')->unique();
            $table->text('noi_dung');
            $table->string('hinh_anh')->nullable();
            $table->datetime('ngay_dang');
            $table->integer('luot_xem')->default(0);
            $table->integer('tinh_trang')->default(1);
            $table->integer('id_nhan_vien');
            $table->integer('id_loai_bai_viet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_viets');
    }
};
