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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->nullable()
                ->after('id')
                ->constrained('roles')
                ->nullOnDelete();
            $table->string('username')
                ->unique()
                ->after('name');
            $table->enum('status', ['active', 'inactive', 'suspended'])
                ->default('active')
                ->after('email');
            $table->string('phone', 30)
                ->nullable()
                ->after('status');
            $table->string('avatar_path')
                ->nullable()
                ->after('phone');
            $table->text('bio')
                ->nullable()
                ->after('avatar_path');
            $table->timestamp('joined_at')
                ->nullable()
                ->after('bio');
            $table->timestamp('last_login_at')
                ->nullable()
                ->after('joined_at');
            $table->json('preferences')
                ->nullable()
                ->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
            $table->dropColumn([
                'username',
                'status',
                'phone',
                'avatar_path',
                'bio',
                'joined_at',
                'last_login_at',
                'preferences',
            ]);
        });
    }
};
