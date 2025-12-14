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
        Schema::create('hoa_don_hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoc_sinh');
            $table->integer('id_lop');
            $table->string('hoc_phi_thang_nam');
            $table->decimal('tong_tien', 10, 2);
            $table->decimal('da_thanh_toan', 10, 2);
            $table->decimal('con_no', 10, 2);
            $table->integer('tinh_trang')->default(1);
            $table->date('ngay_tao');
            $table->date('ngay_thanh_toan')->nullable();
            $table->integer('id_nhan_vien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_don_hoc_phis');
    }
};
