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
        Schema::create('challenge_progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_participant_id')
                ->constrained('challenge_participants')
                ->cascadeOnDelete();
            $table->date('logged_for')->nullable();
            $table->enum('activity_type', ['submission', 'check_in', 'milestone', 'adjustment'])
                ->default('submission');
            $table->text('description')->nullable();
            $table->decimal('metric_value', 10, 2)->nullable();
            $table->string('metric_unit')->nullable();
            $table->json('attachments')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(
                ['challenge_participant_id', 'activity_type'],
                'cpl_participant_activity_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_progress_logs');
    }
};
