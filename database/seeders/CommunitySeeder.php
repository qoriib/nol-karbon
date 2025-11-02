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
        $baseUsers = [
            'miguel@noldomain.test',
            'dania@noldomain.test',
            'leon@noldomain.test',
            'siti.admin@noldomain.test',
            'budi.admin@noldomain.test',
            'alya.contributor@noldomain.test',
            'rangga.contributor@noldomain.test',
            'dewi.contributor@noldomain.test',
            'rizki.user@noldomain.test',
            'citra.user@noldomain.test',
            'mutia.user@noldomain.test',
            'raka.user@noldomain.test',
            'nadia.user@noldomain.test',
            'tegar.user@noldomain.test',
        ];

        $users = User::whereIn('email', $baseUsers)->get()->keyBy('email');

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
            [
                'name' => 'Universitas Gadjah Mada',
                'slug' => 'universitas-gadjah-mada',
                'type' => 'university',
                'tagline' => 'Sustainable Jogja Movement',
                'description' => 'Kolaborasi mahasiswa lintas fakultas untuk pengelolaan energi dan limbah kampus.',
                'city' => 'Yogyakarta',
                'province' => 'DI Yogyakarta',
                'created_by' => $users['siti.admin@noldomain.test']->id ?? null,
                'total_members' => 310,
                'total_points' => 83000,
                'total_emission_reduced' => 1760.42,
            ],
            [
                'name' => 'Eco Warriors Community',
                'slug' => 'eco-warriors-community',
                'type' => 'community',
                'tagline' => 'Youth for Clean Air',
                'description' => 'Komunitas pelajar yang fokus pada kampanye emisi rendah melalui edukasi dan aksi rutin.',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'created_by' => $users['alya.contributor@noldomain.test']->id ?? null,
                'total_members' => 180,
                'total_points' => 62000,
                'total_emission_reduced' => 1254.88,
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
