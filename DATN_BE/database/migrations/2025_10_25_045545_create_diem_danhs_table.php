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
        Schema::create('diem_danhs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_lop_hoc');
            $table->integer('id_hoc_sinh');
            $table->date('ngay_diem_danh');
            $table->boolean('tinh_trang')->default(true);
            $table->string('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diem_danhs');
    }
};
