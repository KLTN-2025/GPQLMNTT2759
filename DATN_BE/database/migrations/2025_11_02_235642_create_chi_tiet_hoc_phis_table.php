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
        Schema::create('chi_tiet_hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoa_don_hoc_phi');
            $table->integer('id_hoc_phi');
            $table->integer('so_luong');
            $table->decimal('don_gia', 10, 2);
            $table->decimal('thanh_tien', 10, 2);
            $table->text('ghi_chu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_hoc_phis');
    }
};
