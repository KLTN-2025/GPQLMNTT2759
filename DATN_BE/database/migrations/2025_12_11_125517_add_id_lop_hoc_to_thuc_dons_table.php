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
        Schema::table('thuc_dons', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('thuc_dons', 'id_lop_hoc')) {
                $table->integer('id_lop_hoc')->nullable()->after('ngay');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thuc_dons', function (Blueprint $table) {
            if (Schema::hasColumn('thuc_dons', 'id_lop_hoc')) {
                $table->dropColumn('id_lop_hoc');
            }
        });
    }
};
