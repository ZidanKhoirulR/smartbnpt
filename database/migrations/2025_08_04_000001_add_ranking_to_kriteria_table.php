<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->integer('ranking')->nullable()->after('bobot')->comment('Ranking untuk ROC calculation');
        });
    }

    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->dropColumn('ranking');
        });
    }
};