<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Manages the platform, reviews content, and oversees reports.',
                'is_default' => false,
            ],
            [
                'name' => 'contributor',
                'display_name' => 'Contributor',
                'description' => 'Creates and maintains educational content about sustainability.',
                'is_default' => false,
            ],
            [
                'name' => 'user',
                'display_name' => 'Community Member',
                'description' => 'Participates in challenges and tracks personal emissions.',
                'is_default' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
