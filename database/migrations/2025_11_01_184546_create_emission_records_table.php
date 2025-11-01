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
        Schema::create('emission_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('community_id')
                ->nullable()
                ->constrained('communities')
                ->nullOnDelete();
            $table->enum('scope', ['personal', 'community', 'campaign'])->default('personal');
            $table->date('recorded_for');
            $table->decimal('emission_kg_co2', 12, 2);
            $table->decimal('reduction_kg_co2', 12, 2)->default(0);
            $table->string('category')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->string('evidence_path')->nullable();
            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'recorded_for']);
            $table->index(['community_id', 'recorded_for']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_records');
    }
};
