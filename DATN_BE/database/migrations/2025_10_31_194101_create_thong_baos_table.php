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
        Schema::create('thong_baos', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('hinh_anh')->nullable();
            $table->string('tep_dinh_kem')->nullable();
            $table->datetime('thoi_gian_dang');
            $table->date('ngay_het_hieu_luc');
            $table->integer('tinh_trang')->default(1);
            $table->integer('id_nhan_vien');
            $table->integer('loai_thong_bao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_baos');
    }
};
