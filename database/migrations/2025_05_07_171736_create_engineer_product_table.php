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
        Schema::create('engineer_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('engineer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Prevent duplicate assignments
            $table->unique(['engineer_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engineer_product');
    }

    /**
     * Reverse the migrations.
     */

};
