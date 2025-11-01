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
        Schema::create('emission_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('card_number')->unique();
            $table->enum('status', ['draft', 'active', 'revoked', 'expired'])->default('draft');
            $table->decimal('total_emission_kg_co2', 12, 2)->default(0);
            $table->decimal('total_reduction_kg_co2', 12, 2)->default(0);
            $table->text('summary')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_cards');
    }
};
