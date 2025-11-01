<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleReview;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::where('email', 'dania@noldomain.test')->first();
        $adminReviewer = User::where('email', 'miguel@noldomain.test')->first();

        if (! $author) {
            return;
        }

        $articles = [
            [
                'title' => 'Zero Carbon for Better Life Start by Little Yourself',
                'status' => 'pending_review',
                'submitted_at' => Carbon::now()->subDays(5),
                'tags' => ['carbon', 'lifestyle'],
                'excerpt' => 'Langkah kecil untuk mengurangi jejak karbon pribadi Anda.',
            ],
            [
                'title' => 'Membangun Komunitas Hijau di Kampus',
                'status' => 'published',
                'submitted_at' => Carbon::now()->subDays(21),
                'published_at' => Carbon::now()->subDays(14),
                'tags' => ['community', 'kampus'],
                'excerpt' => 'Strategi kolaboratif untuk komunitas kampus menuju nol emisi.',
            ],
            [
                'title' => 'Mengganti Transportasi Harian dengan Sepeda',
                'status' => 'needs_revision',
                'submitted_at' => Carbon::now()->subDays(9),
                'needs_revision_at' => Carbon::now()->subDays(2),
                'tags' => ['transportasi', 'challenge'],
                'excerpt' => 'Bagaimana tantangan bersepeda dapat menurunkan emisi CO₂.',
            ],
        ];

        foreach ($articles as $data) {
            $slug = Str::slug($data['title']);

            $article = Article::updateOrCreate(
                ['slug' => $slug],
                array_merge([
                    'author_id' => $author->id,
                    'slug' => $slug,
                    'content' => 'Konten artikel contoh untuk Nol Karbon yang menjelaskan inisiatif dan tips praktis.',
                    'cover_image_path' => 'images/articles/' . $slug . '.jpg',
                    'meta' => [
                        'estimated_read_minutes' => 6,
                    ],
                ], $data)
            );

            if ($adminReviewer) {
                ArticleReview::updateOrCreate(
                    [
                        'article_id' => $article->id,
                        'reviewer_id' => $adminReviewer->id,
                    ],
                    [
                        'decision' => $this->mapStatusToDecision($article->status),
                        'notes' => 'Terima kasih atas kontribusinya! Mohon lanjutkan kampanye edukasi hijau.',
                        'change_requests' => $article->status === 'needs_revision'
                            ? ['Tambahkan data statistik emisi kampus terbaru.']
                            : null,
                        'reviewed_at' => Carbon::now()->subDays(1),
                        'metadata' => [
                            'version' => 1,
                        ],
                    ]
                );
            }
        }
    }

    private function mapStatusToDecision(string $status): string
    {
        return match ($status) {
            'published' => 'published',
            'needs_revision' => 'revision_requested',
            'rejected' => 'rejected',
            'pending_review' => 'pending',
            default => 'pending',
        };
    }
}
