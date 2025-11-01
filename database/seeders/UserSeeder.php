<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::pluck('id', 'name');

        $users = [
            [
                'name' => 'Miguel Alexandro',
                'username' => 'miguel',
                'email' => 'miguel@noldomain.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Dania Aurel',
                'username' => 'dania',
                'email' => 'dania@noldomain.test',
                'role' => 'contributor',
            ],
            [
                'name' => 'Leon Kennedy',
                'username' => 'leon',
                'email' => 'leon@noldomain.test',
                'role' => 'user',
            ],
        ];

        foreach ($users as $index => $user) {
            $roleId = $roles[$user['role']] ?? $roles['user'] ?? null;

            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'role_id' => $roleId,
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'password' => Hash::make('Password123!'),
                    'status' => 'active',
                    'phone' => '0812-0000-00' . ($index + 1),
                    'avatar_path' => null,
                    'bio' => 'Eco enthusiast and active member of the Nol Karbon community.',
                    'joined_at' => Carbon::now()->subMonths(rand(1, 8)),
                    'last_login_at' => Carbon::now()->subDays(rand(1, 10)),
                    'preferences' => [
                        'language' => 'id',
                        'newsletter' => true,
                    ],
                    'remember_token' => Str::random(10),
                ]
            );
        }
    }
}
