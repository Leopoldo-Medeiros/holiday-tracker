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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('product');
            $table->foreignId('assignee_id')->constrained('engineers');
            $table->string('status'); // in_progress, needs_reassignment, reassigned
            $table->foreignId('temporary_assigned_to')->nullable()->constrained('engineers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
