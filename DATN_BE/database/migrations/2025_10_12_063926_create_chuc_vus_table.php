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
        Schema::create('chuc_vus', function (Blueprint $table) {
            $table->id();
             $table->string('ten_chuc_vu')->unique();
            $table->string('slug_chuc_vu')->unique();
            $table->string('mo_ta')->nullable();
            $table->string('loai_chuc_vu')->nullable();
            $table->integer('tinh_trang')->default(1)->comment('1: Hoạt động, 0: Không hoạt động');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuc_vus');
    }
};
