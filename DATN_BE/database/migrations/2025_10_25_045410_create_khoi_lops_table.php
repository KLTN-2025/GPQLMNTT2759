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
        Schema::create('khoi_lops', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khoi_lop')->unique();
            $table->string('do_tuoi');
            $table->text('mo_ta')->nullable();
            $table->integer('so_luong_lop')->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khoi_lops');
    }
};
