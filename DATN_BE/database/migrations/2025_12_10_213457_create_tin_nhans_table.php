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
        Schema::create('tin_nhans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuoc_tro_chuyen_id');
            $table->string('loai_nguoi_gui'); // 'giao_vien' or 'phu_huynh'
            $table->unsignedBigInteger('nguoi_gui_id');
            $table->text('noi_dung');
            $table->boolean('da_doc')->default(false);
            $table->string('file_dinh_kem')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('cuoc_tro_chuyen_id');
            $table->index(['cuoc_tro_chuyen_id', 'created_at']);
            $table->index(['cuoc_tro_chuyen_id', 'da_doc']);

            // Foreign key
            $table->foreign('cuoc_tro_chuyen_id')->references('id')->on('cuoc_tro_chuyen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tin_nhans');
    }
};
