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
        Schema::create('doc_tin_nhan_nhom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tin_nhan_nhom_id')->constrained('tin_nhan_nhom')->onDelete('cascade');
            $table->enum('loai_nguoi_doc', ['giao_vien', 'phu_huynh']);
            $table->unsignedBigInteger('nguoi_doc_id');
            $table->boolean('da_doc')->default(false);
            $table->timestamp('doc_luc')->nullable();
            $table->timestamps();

            $table->unique(['tin_nhan_nhom_id', 'loai_nguoi_doc', 'nguoi_doc_id'], 'unique_reader');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_tin_nhan_nhom');
    }
};
