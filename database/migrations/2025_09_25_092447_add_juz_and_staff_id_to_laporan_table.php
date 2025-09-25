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
        Schema::table('laporan', function (Blueprint $table) {
            $table->string('juz')->nullable()->after('halaman'); // Kolom juz
            $table->foreignId('staff_id')->nullable()->constrained('staff')->after('juz'); // Relasi ke tabel staff
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropColumn(['juz', 'staff_id']);
        });
    }
};
