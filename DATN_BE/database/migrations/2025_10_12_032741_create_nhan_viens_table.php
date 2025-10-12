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
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten');
            $table->string('so_dien_thoai');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->integer('id_chuc_vu');
            $table->string('password');
            $table->integer('gioi_tinh')->comment('0: Nữ, 1: Nam, 2: Khác');
            $table->string('dia_chi');
            $table->date('ngay_sinh');
            $table->boolean('is_block')->default(0)->comment('0: Không khóa, 1: Khóa');
            $table->boolean('tinh_trang')->default(1)->comment('1: Hoạt động, 0: Không hoạt động');
            $table->string('hash_reset')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_viens');
    }
};
