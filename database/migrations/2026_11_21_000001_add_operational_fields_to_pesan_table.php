<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pesan', 'status_pesanan')) {
            Schema::table('pesan', function (Blueprint $table) {
                $table->string('status_pesanan', 30)->default('Menunggu Pembayaran')->after('status_bayar');
            });
        }

        if (!Schema::hasColumn('pesan', 'nomor_resi')) {
            Schema::table('pesan', function (Blueprint $table) {
                $table->string('nomor_resi', 100)->nullable()->after('metode_pengiriman');
            });
        }

        // Migrasikan status operasional lama yang sebelumnya disimpan di
        // status_bayar agar data lama tetap tampil di dashboard Staff.
        DB::table('pesan')
            ->whereIn('status_bayar', ['Diproses', 'Dalam Pengiriman', 'Selesai'])
            ->update(['status_pesanan' => DB::raw('status_bayar')]);

        DB::table('pesan')
            ->where('status_bayar', 'Lunas')
            ->where('status_pesanan', 'Menunggu Pembayaran')
            ->update(['status_pesanan' => 'Lunas']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('pesan', 'nomor_resi')) {
            Schema::table('pesan', fn (Blueprint $table) => $table->dropColumn('nomor_resi'));
        }

        if (Schema::hasColumn('pesan', 'status_pesanan')) {
            Schema::table('pesan', fn (Blueprint $table) => $table->dropColumn('status_pesanan'));
        }
    }
};
