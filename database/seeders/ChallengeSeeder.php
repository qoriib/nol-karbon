<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengeParticipant;
use App\Models\ChallengeProgressLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'miguel@noldomain.test')->first();
        $members = User::whereIn('email', [
            'dania@noldomain.test',
            'leon@noldomain.test',
        ])->get();

        if (! $admin || $members->isEmpty()) {
            return;
        }

        $challenges = [
            [
                'title' => 'Weekly Plastic Challenge',
                'description' => 'Kurangi penggunaan plastik sekali pakai selama satu minggu penuh.',
                'instructions' => 'Catat setiap pengurangan plastik harian dan unggah bukti foto.',
                'point_reward' => 5,
                'bonus_point' => 10,
                'start_date' => Carbon::parse('2025-06-02'),
                'end_date' => Carbon::parse('2025-06-09'),
                'status' => 'active',
                'visibility' => 'public',
            ],
            [
                'title' => 'Sepeda 30 Hari',
                'description' => 'Gunakan sepeda untuk perjalanan ke kampus selama 30 hari.',
                'instructions' => 'Laporkan jarak tempuh mingguan dan foto aktivitas.',
                'point_reward' => 95,
                'bonus_point' => 25,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(20),
                'status' => 'active',
                'visibility' => 'public',
            ],
            [
                'title' => 'Diet Plant-Based 7 Hari',
                'description' => 'Tantang diri untuk diet plant-based selama seminggu untuk menekan emisi karbon dari makanan.',
                'instructions' => 'Laporkan menu harian dan unggah foto hidangan plant-based kamu.',
                'point_reward' => 40,
                'bonus_point' => 10,
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addDays(10),
                'status' => 'upcoming',
                'visibility' => 'public',
            ],
            [
                'title' => 'Hemat Energi Kampus',
                'description' => 'Kurangi konsumsi listrik dan matikan peralatan yang tidak digunakan di lingkungan kampus.',
                'instructions' => 'Catat penghematan listrik dan laporkan tindakan spesifik yang dilakukan.',
                'point_reward' => 30,
                'bonus_point' => 5,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(1),
                'status' => 'completed',
                'visibility' => 'public',
            ],
        ];

        foreach ($challenges as $challengeData) {
            $slug = Str::slug($challengeData['title']);

            $challenge = Challenge::updateOrCreate(
                ['slug' => $slug],
                array_merge($challengeData, [
                    'slug' => $slug,
                    'created_by' => $admin->id,
                    'max_participants' => $challengeData['max_participants'] ?? 500,
                    'cover_image_path' => $challengeData['cover_image_path'] ?? 'challenges/' . $slug . '.jpg',
                    'requirements' => $challengeData['requirements'] ?? [
                        'min_check_ins' => 5,
                        'evidence' => 'photo',
                    ],
                    'metadata' => [
                        'category' => 'lifestyle',
                    ],
                ])
            );

            foreach ($members as $member) {
                $participant = ChallengeParticipant::updateOrCreate(
                    [
                        'challenge_id' => $challenge->id,
                        'user_id' => $member->id,
                    ],
                    [
                        'status' => 'joined',
                        'progress_percentage' => rand(35, 95),
                        'points_earned' => $challenge->point_reward + rand(0, $challenge->bonus_point),
                        'joined_at' => Carbon::now()->subDays(rand(3, 12)),
                        'last_reported_at' => Carbon::now()->subDays(rand(1, 3)),
                        'metadata' => [
                            'team' => 'Green Warriors',
                        ],
                    ]
                );

                ChallengeProgressLog::updateOrCreate(
                    [
                        'challenge_participant_id' => $participant->id,
                        'logged_for' => Carbon::now()->subDays(2)->toDateString(),
                        'activity_type' => 'submission',
                    ],
                    [
                        'description' => 'Mengunggah bukti aktivitas ramah lingkungan.',
                        'metric_value' => rand(3, 7),
                        'metric_unit' => 'kegiatan',
                        'attachments' => [
                            'images' => ['proof-' . $participant->id . '.jpg'],
                        ],
                        'metadata' => [
                            'validated_by_admin' => true,
                        ],
                ]
            );
        }

        $secondaryAdmin = User::where('email', 'budi.admin@noldomain.test')->first();
        $secondaryMembers = User::whereIn('email', [
            'rizki.user@noldomain.test',
            'citra.user@noldomain.test',
            'mutia.user@noldomain.test',
            'raka.user@noldomain.test',
        ])->get();

        if ($secondaryAdmin && $secondaryMembers->isNotEmpty()) {
            $additionalChallenges = [
                [
                    'title' => 'Zero Waste Dormitory Week',
                    'description' => 'Ajak penghuni asrama kampus mengurangi sampah selama satu minggu penuh.',
                    'instructions' => 'Catat berat sampah harian dan bagikan tips pengelolaan sampah organik & anorganik.',
                    'point_reward' => 60,
                    'bonus_point' => 15,
                    'start_date' => Carbon::now()->addDays(5),
                    'end_date' => Carbon::now()->addDays(12),
                    'status' => 'upcoming',
                    'visibility' => 'private',
                    'max_participants' => 150,
                    'requirements' => ['min_check_ins' => 3, 'evidence' => 'photo'],
                ],
                [
                    'title' => 'Campus Car Free Day',
                    'description' => 'Gerakan berjalan kaki dan bersepeda ke kampus setiap Jumat selama satu bulan.',
                    'instructions' => 'Laporkan jarak tempuh dan foto titik car free day di sekitar kampus.',
                    'point_reward' => 80,
                    'bonus_point' => 20,
                    'start_date' => Carbon::now()->subDays(25),
                    'end_date' => Carbon::now()->subDays(5),
                    'status' => 'completed',
                    'visibility' => 'public',
                    'max_participants' => 1000,
                    'requirements' => ['min_check_ins' => 4, 'evidence' => 'photo'],
                ],
                [
                    'title' => 'Green Content Creator Marathon',
                    'description' => 'Buat konten edukasi nol karbon selama 14 hari dan bagikan di media sosial kampus.',
                    'instructions' => 'Unggah tautan konten harian dan catat reach atau interaksi penting.',
                    'point_reward' => 120,
                    'bonus_point' => 35,
                    'start_date' => Carbon::now()->addDays(1),
                    'end_date' => Carbon::now()->addDays(15),
                    'status' => 'upcoming',
                    'visibility' => 'public',
                    'max_participants' => 300,
                    'requirements' => ['min_check_ins' => 7, 'evidence' => 'link'],
                ],
            ];

            foreach ($additionalChallenges as $challengeData) {
                $slug = Str::slug($challengeData['title']);

                $challenge = Challenge::updateOrCreate(
                    ['slug' => $slug],
                array_merge($challengeData, [
                    'slug' => $slug,
                    'created_by' => $secondaryAdmin->id,
                    'cover_image_path' => $challengeData['cover_image_path'] ?? 'challenges/' . $slug . '.jpg',
                    'metadata' => [
                        'category' => 'campaign',
                    ],
                ])
                );

                foreach ($secondaryMembers as $member) {
                    $participant = ChallengeParticipant::updateOrCreate(
                        [
                            'challenge_id' => $challenge->id,
                            'user_id' => $member->id,
                        ],
                        [
                            'status' => $challenge->status === 'completed' ? 'completed' : 'joined',
                            'progress_percentage' => $challenge->status === 'completed'
                                ? 100
                                : rand(20, 85),
                            'points_earned' => $challenge->point_reward + rand(0, (int) $challenge->bonus_point),
                            'joined_at' => Carbon::now()->subDays(rand(5, 15)),
                            'completed_at' => $challenge->status === 'completed'
                                ? Carbon::now()->subDays(rand(1, 4))
                                : null,
                            'last_reported_at' => Carbon::now()->subDays(rand(1, 6)),
                            'metadata' => [
                                'team' => 'Eco Squad ' . Str::upper(Str::random(2)),
                            ],
                        ]
                    );

                    ChallengeProgressLog::updateOrCreate(
                        [
                            'challenge_participant_id' => $participant->id,
                            'logged_for' => Carbon::now()->subDays(rand(1, 6))->toDateString(),
                            'activity_type' => 'submission',
                        ],
                        [
                            'description' => 'Mengunggah bukti kegiatan hijau harian.',
                            'metric_value' => rand(1, 5),
                            'metric_unit' => 'aksi',
                            'attachments' => [
                                'images' => ['proof-extra-' . $participant->id . '.jpg'],
                            ],
                            'metadata' => ['validated_by_admin' => (bool) rand(0, 1)],
                        ]
                    );
                }
            }
        }
    }
}
}
