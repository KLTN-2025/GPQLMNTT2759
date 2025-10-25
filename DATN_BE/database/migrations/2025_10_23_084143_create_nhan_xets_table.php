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
        Schema::create('nhan_xets', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoc_sinh');
            $table->date('ngay_nhan_xet');
            $table->integer('id_giao_vien');
            $table->text('noi_dung');
            $table->string('danh_gia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_xets');
    }
};
