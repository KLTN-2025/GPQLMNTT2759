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
        Schema::create('hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->string('ten_loai_phi');
            $table->decimal('don_gia', 10, 2);
            $table->string('don_vi_tinh');
            $table->date('ap_dung_tu_ngay');
            $table->date('ap_dung_den_ngay');
            $table->text('mo_ta')->nullable();
            $table->integer('tinh_trang')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoc_phis');
    }
};
