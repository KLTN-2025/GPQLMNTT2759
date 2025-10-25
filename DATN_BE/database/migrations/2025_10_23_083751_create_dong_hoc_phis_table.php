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
        Schema::create('dong_hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoc_phi');
            $table->integer('id_hoc_sinh');
            $table->decimal('so_tien_dong', 10, 2);
            $table->date('ngay_dong');
            $table->string('hinh_thuc_thanh_toan');
            $table->string('ghi_chu');
            $table->boolean('tinh_trang')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dong_hoc_phis');
    }
};
