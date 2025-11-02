<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Challenge;
use App\Models\Community;
use App\Models\CommunityStatistic;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReportingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'miguel@noldomain.test')->first();
        $contributor = User::where('email', 'dania@noldomain.test')->first();
        $member = User::where('email', 'leon@noldomain.test')->first();
        $challenge = Challenge::first();
        $article = Article::first();
        $additionalChallenges = Challenge::latest()->take(3)->get();

        if ($admin && $challenge) {
            UserActivity::updateOrCreate(
                [
                    'user_id' => $admin->id,
                    'activity_type' => 'challenge_created',
                    'subject_type' => Challenge::class,
                    'subject_id' => $challenge->id,
                ],
                [
                    'description' => 'Membuat tantangan lingkungan baru untuk komunitas kampus.',
                    'performed_by' => $admin->id,
                    'occurred_at' => Carbon::now()->subDays(3),
                    'metadata' => [
                        'visibility' => $challenge->visibility,
                    ],
                ]
            );
        }

        if ($contributor && $article) {
            UserActivity::updateOrCreate(
                [
                    'user_id' => $contributor->id,
                    'activity_type' => 'article_submitted',
                    'subject_type' => Article::class,
                    'subject_id' => $article->id,
                ],
                [
                    'description' => 'Mengirimkan artikel edukasi terbaru untuk direview.',
                    'performed_by' => $contributor->id,
                    'occurred_at' => Carbon::now()->subDays(5),
                    'metadata' => [
                        'status' => $article->status,
                    ],
                ]
            );
        }

        if ($member && $challenge) {
            UserActivity::updateOrCreate(
                [
                    'user_id' => $member->id,
                    'activity_type' => 'challenge_progress',
                    'subject_type' => Challenge::class,
                    'subject_id' => $challenge->id,
                ],
                [
                    'description' => 'Melaporkan progres tantangan sepeda harian.',
                    'performed_by' => $member->id,
                    'occurred_at' => Carbon::now()->subDays(1),
                    'metadata' => [
                        'progress_percentage' => 65,
                    ],
                ]
            );
        }

        if ($admin && $challenge) {
            foreach ($additionalChallenges as $index => $adminChallenge) {
                UserActivity::updateOrCreate(
                    [
                        'user_id' => $admin->id,
                        'activity_type' => 'challenge_updated',
                        'subject_type' => Challenge::class,
                        'subject_id' => $adminChallenge->id,
                    ],
                    [
                        'description' => 'Memperbarui detail tantangan #' . ($index + 1),
                        'performed_by' => $admin->id,
                        'occurred_at' => Carbon::now()->subHours(rand(6, 48)),
                        'metadata' => [
                            'status' => $adminChallenge->status,
                        ],
                    ]
                );
            }
        }

        $periods = [
            [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()],
            [Carbon::now()->subQuarter()->startOfQuarter(), Carbon::now()->subQuarter()->endOfQuarter()],
        ];

        Community::all()->each(function (Community $community) use ($periods) {
            foreach ($periods as [$start, $end]) {
                CommunityStatistic::updateOrCreate(
                    [
                        'community_id' => $community->id,
                        'period_start' => $start->toDateString(),
                        'period_end' => $end->toDateString(),
                    ],
                    [
                        'total_members' => $community->total_members,
                        'active_members' => (int) round($community->total_members * (0.6 + rand(0, 15) / 100)),
                        'total_points' => $community->total_points - rand(0, 8000),
                        'total_emission_kg_co2' => $community->total_emission_reduced - rand(0, 200),
                        'average_monthly_emission_kg_co2' => max(1, ($community->total_emission_reduced / 3) - rand(0, 50)),
                        'challenge_participants_count' => rand(80, 180),
                        'active_challenges_count' => rand(2, 7),
                        'metadata' => [
                            'top_initiatives' => [
                                'Eco bricks',
                                'Smart mobility',
                                'Urban farming',
                            ],
                        ],
                    ]
                );
            }
        });
    }
}
