<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 20);
            $table->string('transaction_type', 50);
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2)->default(0);
            $table->decimal('balance_after', 12, 2)->default(0);
            $table->string('reference_id')->unique();
            $table->string('status', 20)->default('pending');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'transaction_type']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_wallet_transactions');
    }
};
