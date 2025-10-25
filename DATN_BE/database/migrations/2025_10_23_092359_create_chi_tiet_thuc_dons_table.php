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
        Schema::create('chi_tiet_thuc_dons', function (Blueprint $table) {
            $table->id();
            $table->integer('id_thuc_don');
            $table->integer('id_mon_an');
            $table->integer('id_bua_an');
            $table->integer('so_luong')->default(1);
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_thuc_dons');
    }
};
