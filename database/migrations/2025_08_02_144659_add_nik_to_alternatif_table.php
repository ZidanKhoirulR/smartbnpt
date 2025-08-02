<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah kolom nik sudah ada
        if (!Schema::hasColumn('alternatif', 'nik')) {
            Schema::table('alternatif', function (Blueprint $table) {
                $table->string('nik', 16)->nullable()->after('kode');
            });
        }

        // Update data yang kosong atau null
        $alternatifs = DB::table('alternatif')->whereNull('nik')->orWhere('nik', '')->get();
        foreach ($alternatifs as $alternatif) {
            DB::table('alternatif')
                ->where('id', $alternatif->id)
                ->update(['nik' => '320123456789' . str_pad($alternatif->id, 4, '0', STR_PAD_LEFT)]);
        }

        // Cek apakah unique constraint sudah ada
        $indexes = DB::select("SHOW INDEX FROM alternatif WHERE Key_name = 'alternatif_nik_unique'");
        if (empty($indexes)) {
            Schema::table('alternatif', function (Blueprint $table) {
                $table->unique('nik', 'alternatif_nik_unique');
            });
        }

        // Ubah menjadi not null jika masih nullable
        Schema::table('alternatif', function (Blueprint $table) {
            $table->string('nik', 16)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alternatif', function (Blueprint $table) {
            $table->dropUnique('alternatif_nik_unique');
            $table->dropColumn('nik');
        });
    }
};