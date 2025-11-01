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
        Schema::create('community_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')
                ->constrained('communities')
                ->cascadeOnDelete();
            $table->date('period_start');
            $table->date('period_end');
            $table->unsignedBigInteger('total_members')->default(0);
            $table->unsignedBigInteger('active_members')->default(0);
            $table->unsignedBigInteger('total_points')->default(0);
            $table->decimal('total_emission_kg_co2', 12, 2)->default(0);
            $table->decimal('average_monthly_emission_kg_co2', 12, 2)->default(0);
            $table->unsignedInteger('challenge_participants_count')->default(0);
            $table->unsignedInteger('active_challenges_count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['community_id', 'period_start', 'period_end'], 'community_period_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_statistics');
    }
};
