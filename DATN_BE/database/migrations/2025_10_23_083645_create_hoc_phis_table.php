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
            $table->string('ten_hoc_phi');
            $table->decimal('so_tien', 10, 2);
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->text('mo_ta')->nullable();
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
