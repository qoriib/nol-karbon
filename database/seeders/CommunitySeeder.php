<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereIn('email', [
            'miguel@noldomain.test',
            'dania@noldomain.test',
            'leon@noldomain.test',
        ])->get()->keyBy('email');

        $communities = [
            [
                'name' => 'Universitas Brawijaya',
                'slug' => 'universitas-brawijaya',
                'type' => 'university',
                'tagline' => 'Green Campus Initiative',
                'description' => 'Menginisiasi gerakan kampus hijau dan pengurangan emisi karbon.',
                'city' => 'Malang',
                'province' => 'Jawa Timur',
                'created_by' => $users['miguel@noldomain.test']->id ?? null,
                'total_members' => 350,
                'total_points' => 100000,
                'total_emission_reduced' => 2450.50,
            ],
            [
                'name' => 'Institut Teknologi Bandung',
                'slug' => 'institut-teknologi-bandung',
                'type' => 'university',
                'tagline' => 'Tech for Sustainable Future',
                'description' => 'Kolaborasi teknologi untuk memonitor dan menurunkan emisi kampus.',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'created_by' => $users['miguel@noldomain.test']->id ?? null,
                'total_members' => 290,
                'total_points' => 90000,
                'total_emission_reduced' => 1987.35,
            ],
        ];

        foreach ($communities as $communityData) {
            $community = Community::updateOrCreate(
                ['slug' => $communityData['slug']],
                array_merge($communityData, [
                    'status' => 'active',
                    'metadata' => [
                        'focus_programs' => [
                            'waste_management',
                            'energy_efficiency',
                        ],
                    ],
                ])
            );

            $members = [];
            foreach ($users as $user) {
                $members[$user->id] = [
                    'role' => $user->role?->name === 'admin' ? 'admin' : 'member',
                    'status' => 'active',
                    'points_accumulated' => rand(500, 5000),
                    'joined_at' => Carbon::now()->subMonths(rand(1, 12))->toDateTimeString(),
                    'metadata' => json_encode([
                        'contribution_area' => $user->role?->name === 'contributor'
                            ? 'content'
                            : 'challenge',
                    ]),
                ];
            }

            $community->members()->syncWithoutDetaching($members);
        }

        foreach ($users as $user) {
            $primaryCommunity = Community::where('status', 'active')->inRandomOrder()->first();
            if ($primaryCommunity) {
                $user->update(['primary_community_id' => $primaryCommunity->id]);
            }
        }
    }
}
