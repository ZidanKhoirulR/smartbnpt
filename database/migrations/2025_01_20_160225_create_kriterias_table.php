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
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 6)->unique();
            $table->integer('ranking')->nullable()->after('kode');
            $table->index('ranking');
            $table->string('kriteria');
            $table->integer('bobot');
            $table->enum('jenis_kriteria', ['cost', 'benefit'])->default('benefit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->dropIndex(['ranking']);
            $table->dropColumn('ranking');
        });
        $this->setDefaultRankings();
    }

    /**
     * Set default ranking untuk data yang sudah ada
     */
    private function setDefaultRankings(): void
    {
        // Ambil semua kriteria dan urutkan berdasarkan bobot tertinggi
        $kriteria = DB::table('kriteria')
            ->orderBy('bobot', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        // Set ranking berdasarkan urutan bobot
        foreach ($kriteria as $index => $item) {
            DB::table('kriteria')
                ->where('id', $item->id)
                ->update(['ranking' => $index + 1]);
        }
    }
};
