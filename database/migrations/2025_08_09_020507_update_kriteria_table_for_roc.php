<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Kriteria;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            // Pastikan kolom ranking ada dan tidak nullable
            if (!Schema::hasColumn('kriteria', 'ranking')) {
                $table->integer('ranking')->after('bobot')->nullable();
            }

            // Update presisi bobot untuk ROC (4 decimal places)
            $table->decimal('bobot', 6, 4)->change();
        });

        // Auto-generate ranking untuk kriteria yang sudah ada
        $this->generateRankingForExistingData();

        // Setelah generate ranking, buat ranking menjadi not nullable
        Schema::table('kriteria', function (Blueprint $table) {
            $table->integer('ranking')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            // Kembalikan presisi bobot ke semula
            $table->decimal('bobot', 5, 2)->change();

            // Hapus kolom ranking jika diperlukan
            // $table->dropColumn('ranking');
        });
    }

    /**
     * Generate ranking untuk data yang sudah ada
     */
    private function generateRankingForExistingData(): void
    {
        $kriteria = Kriteria::whereNull('ranking')
            ->orWhere('ranking', 0)
            ->orderBy('bobot', 'desc') // Urutkan berdasarkan bobot lama
            ->orderBy('created_at', 'asc')
            ->get();

        $nextRanking = Kriteria::max('ranking') ?? 0;
        $nextRanking++;

        foreach ($kriteria as $item) {
            $item->update(['ranking' => $nextRanking]);
            $nextRanking++;
        }

        // Recalculate semua bobot ROC
        $this->recalculateAllROCWeights();
    }

    /**
     * Recalculate semua bobot ROC berdasarkan ranking
     */
    private function recalculateAllROCWeights(): void
    {
        $kriteria = Kriteria::whereNotNull('ranking')
            ->orderBy('ranking', 'asc')
            ->get();

        $K = count($kriteria);

        foreach ($kriteria as $item) {
            if ($K > 0) {
                $sum = 0;
                for ($i = $item->ranking; $i <= $K; $i++) {
                    $sum += 1 / $i;
                }

                $bobotROC = (1 / $K) * $sum;
                $item->updateQuietly(['bobot' => round($bobotROC, 4)]);
            }
        }
    }
};