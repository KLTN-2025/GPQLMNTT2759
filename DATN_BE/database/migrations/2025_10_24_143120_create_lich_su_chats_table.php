<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('lich_su_chats', function (Blueprint $table) {
            $table->id();
            $table->integer('nguoi_gui');
            $table->integer('nguoi_nhan');
            $table->text('noi_dung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_chats');
    }
};
