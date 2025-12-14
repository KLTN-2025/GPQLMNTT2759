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
        Schema::create('tin_nhan_nhom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nhom_chat_id')->constrained('nhom_chat_lop')->onDelete('cascade');
            $table->enum('loai_nguoi_gui', ['giao_vien', 'phu_huynh']);
            $table->unsignedBigInteger('nguoi_gui_id');
            $table->text('noi_dung');
            $table->timestamps();

            $table->index(['nhom_chat_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin_nhan_nhom');
    }
};
