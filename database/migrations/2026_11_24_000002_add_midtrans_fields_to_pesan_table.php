<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->string('midtrans_order_id', 100)->nullable()->unique();
            $table->string('midtrans_token', 255)->nullable();
            $table->string('midtrans_status', 40)->nullable();
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pesan', function (Blueprint $table) {
            $table->dropUnique(['midtrans_order_id']);
            $table->dropColumn(['midtrans_order_id', 'midtrans_token', 'midtrans_status', 'paid_at']);
        });
    }
};
