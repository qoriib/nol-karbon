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
                'phone' => '0812-0000-0001',
            ],
            [
                'name' => 'Dania Aurel',
                'username' => 'dania',
                'email' => 'dania@noldomain.test',
                'role' => 'contributor',
                'phone' => '0812-0000-0002',
            ],
            [
                'name' => 'Leon Kennedy',
                'username' => 'leon',
                'email' => 'leon@noldomain.test',
                'role' => 'user',
                'phone' => '0812-0000-0003',
            ],
            [
                'name' => 'Siti Rahma',
                'username' => 'siti',
                'email' => 'siti.admin@noldomain.test',
                'role' => 'admin',
                'phone' => '0813-0000-1001',
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'budi',
                'email' => 'budi.admin@noldomain.test',
                'role' => 'admin',
                'phone' => '0813-0000-1002',
            ],
            [
                'name' => 'Alya Kusuma',
                'username' => 'alya',
                'email' => 'alya.contributor@noldomain.test',
                'role' => 'contributor',
                'phone' => '0813-0000-2001',
            ],
            [
                'name' => 'Rangga Pratama',
                'username' => 'rangga',
                'email' => 'rangga.contributor@noldomain.test',
                'role' => 'contributor',
                'phone' => '0813-0000-2002',
            ],
            [
                'name' => 'Dewi Anggraini',
                'username' => 'dewi',
                'email' => 'dewi.contributor@noldomain.test',
                'role' => 'contributor',
                'phone' => '0813-0000-2003',
            ],
            [
                'name' => 'Rizki Pratama',
                'username' => 'rizki',
                'email' => 'rizki.user@noldomain.test',
                'role' => 'user',
                'phone' => '0813-0000-3001',
            ],
            [
                'name' => 'Citra Lestari',
                'username' => 'citra',
                'email' => 'citra.user@noldomain.test',
                'role' => 'user',
                'phone' => '0813-0000-3002',
            ],
            [
                'name' => 'Mutia Rahmi',
                'username' => 'mutia',
                'email' => 'mutia.user@noldomain.test',
                'role' => 'user',
                'status' => 'inactive',
                'phone' => '0813-0000-3003',
            ],
            [
                'name' => 'Raka Saputra',
                'username' => 'raka',
                'email' => 'raka.user@noldomain.test',
                'role' => 'user',
                'phone' => '0813-0000-3004',
            ],
            [
                'name' => 'Nadia Kharisma',
                'username' => 'nadia',
                'email' => 'nadia.user@noldomain.test',
                'role' => 'user',
                'phone' => '0813-0000-3005',
            ],
            [
                'name' => 'Tegar Aditya',
                'username' => 'tegar',
                'email' => 'tegar.user@noldomain.test',
                'role' => 'user',
                'status' => 'active',
                'phone' => '0813-0000-3006',
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
                    'status' => $user['status'] ?? 'active',
                    'phone' => $user['phone'] ?? '0812-0000-00' . ($index + 1),
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
