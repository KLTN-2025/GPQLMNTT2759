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
        Schema::create('hoc_sinhs', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten');
            $table->string('gioi_tinh');
            $table->string('avatar')->nullable();
            $table->date('ngay_sinh');
            $table->string('dia_chi');
            $table->boolean('tinh_trang')->default(1)->comment('1: Hoạt động, 0: Không hoạt động');
            $table->integer('id_lop_hoc')->nullable();
            $table->integer('id_phu_huynh')->nullable();
            $table->boolean('is_block')->default(0)->comment('0: Không khóa, 1: Khóa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoc_sinhs');
    }
};
