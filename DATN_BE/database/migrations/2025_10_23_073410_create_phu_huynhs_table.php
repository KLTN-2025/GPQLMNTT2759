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
        Schema::create('phu_huynhs', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten');
            $table->string('so_dien_thoai');
            $table->string('email')->unique();
            $table->string('quan_he');
            $table->string('password')->nullable();
            $table->string('gioi_tinh');
            $table->string('dia_chi');
            $table->string('nghe_nghiep');
            $table->date('ngay_sinh');
            $table->integer('is_block')->default(false)->comment('false: Không khóa, true: Khóa');
            $table->integer('is_active')->default(true)->comment('true: Hoạt động, false: Không hoạt động');
            $table->string('hash_reset')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phu_huynhs');
    }
};
