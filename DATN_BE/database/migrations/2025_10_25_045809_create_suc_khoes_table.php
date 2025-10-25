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
        Schema::create('suc_khoes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hoc_sinh');
            $table->date('ngay_kham');
            $table->string('tinh_trang');
            $table->decimal('chieu_cao', 5, 2)->nullable();
            $table->decimal('can_nang', 5, 2)->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suc_khoes');
    }
};
