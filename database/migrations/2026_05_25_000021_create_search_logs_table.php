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
        Schema::create('search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('query', 255)->index();
            $table->enum('type', ['text', 'voice', 'barcode'])->default('text');
            $table->integer('results_count')->default(0);
            $table->unsignedBigInteger('clicked_result_id')->nullable();
            $table->string('clicked_result_type', 50)->nullable(); // product, category, service
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();

            $table->index(['created_at', 'query']);
            $table->index('user_id');
            $table->fullText(['query']); // Full-text index for fast search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_logs');
    }
};
