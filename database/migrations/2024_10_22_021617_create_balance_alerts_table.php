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
        Schema::create('balance_alerts', function (Blueprint $table) {
            $table->id();
            $table->decimal('threshold_amount', 10, 2); // Batas keuangan
            $table->boolean('is_alerted')->default(false); // Status peringatan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_alerts');
    }
};
