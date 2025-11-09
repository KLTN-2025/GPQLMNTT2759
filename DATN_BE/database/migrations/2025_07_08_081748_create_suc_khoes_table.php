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
            $table->decimal('chieu_cao', 5, 2)->nullable();
            $table->decimal('can_nang', 5, 2)->nullable();
            $table->integer('thi_luc')->nullable()->comment('1: Tốt, 2: Khá, 3: Trung bình, 4: Yếu');
            $table->integer('rang_mieng')->nullable()->comment('1: Tốt, 2: Khá, 3: Trung bình, 4: Yếu');
            $table->integer('tinh_trang_suc_khoe')->nullable()->comment('1: Tốt, 2: cần theo dõi, 3: cần can thiệp');
            $table->integer('loai_kham')->default(1)->comment('1: Định kì, 0: cấp cứu');
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
