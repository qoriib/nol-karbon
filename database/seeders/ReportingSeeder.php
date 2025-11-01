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

        Community::all()->each(function (Community $community) {
            CommunityStatistic::updateOrCreate(
                [
                    'community_id' => $community->id,
                    'period_start' => Carbon::now()->startOfQuarter()->toDateString(),
                    'period_end' => Carbon::now()->endOfQuarter()->toDateString(),
                ],
                [
                    'total_members' => $community->total_members,
                    'active_members' => (int) round($community->total_members * 0.72),
                    'total_points' => $community->total_points,
                    'total_emission_kg_co2' => $community->total_emission_reduced,
                    'average_monthly_emission_kg_co2' => $community->total_emission_reduced / 3,
                    'challenge_participants_count' => 125,
                    'active_challenges_count' => 4,
                    'metadata' => [
                        'top_initiatives' => [
                            'Eco bricks',
                            'Smart mobility',
                        ],
                    ],
                ]
            );
        });
    }
}

