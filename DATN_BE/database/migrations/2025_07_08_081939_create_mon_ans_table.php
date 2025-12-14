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
        Schema::create('mon_ans', function (Blueprint $table) {
            $table->id();
            $table->string('ten_mon');
            $table->text('mo_ta')->nullable();
            $table->string('ghi_chu')->nullable();
            $table->string('hinh_anh')->nullable();
            $table->string('loai_mon');
            $table->string('nguon_goc');
            $table->integer('calo');
            $table->decimal('protein', 5, 2)->nullable();
            $table->decimal('carb', 5, 2)->nullable();
            $table->decimal('fat', 5, 2)->nullable();
            $table->boolean('is_block')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mon_ans');
    }
};
