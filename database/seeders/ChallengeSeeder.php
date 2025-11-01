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
        ];

        foreach ($challenges as $challengeData) {
            $slug = Str::slug($challengeData['title']);

            $challenge = Challenge::updateOrCreate(
                ['slug' => $slug],
                array_merge($challengeData, [
                    'slug' => $slug,
                    'created_by' => $admin->id,
                    'max_participants' => 500,
                    'cover_image_path' => 'images/challenges/' . $slug . '.jpg',
                    'requirements' => [
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
        }
    }
}
