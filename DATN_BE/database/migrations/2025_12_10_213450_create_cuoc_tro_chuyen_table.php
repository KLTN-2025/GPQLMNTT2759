<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuoc_tro_chuyen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('giao_vien_id');
            $table->unsignedBigInteger('phu_huynh_id');
            $table->unsignedBigInteger('tin_nhan_cuoi_id')->nullable();
            $table->timestamp('thoi_gian_cuoi')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['giao_vien_id', 'phu_huynh_id']);
            $table->unique(['giao_vien_id', 'phu_huynh_id']); // One conversation per pair

            // Foreign keys
            $table->foreign('giao_vien_id')->references('id')->on('giao_viens')->onDelete('cascade');
            $table->foreign('phu_huynh_id')->references('id')->on('phu_huynhs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuoc_tro_chuyen');
    }
};
