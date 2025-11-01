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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->enum('type', ['university', 'organization', 'community'])->default('university');
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('website_url')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->unsignedBigInteger('total_members')->default(0);
            $table->unsignedBigInteger('total_points')->default(0);
            $table->decimal('total_emission_reduced', 12, 2)->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
