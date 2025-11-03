<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        $communities = Community::select('name', 'total_points', 'total_emission_reduced')
            ->where('status', 'active')
            ->orderByDesc('total_points')
            ->take(12)
            ->get();

        $maxPoints = max($communities->max('total_points') ?? 0, 1);

        $leaderboard = $communities->map(function (Community $community, int $index) use ($maxPoints) {
            $score = $community->total_points > 0
                ? round(($community->total_points / $maxPoints) * 100)
                : 0;

            return [
                'rank' => $index + 1,
                'name' => $community->name,
                'emission' => (float) $community->total_emission_reduced,
                'score' => $score,
            ];
        });

        return view('leaderboard.index', [
            'leaderboard' => $leaderboard,
        ]);
    }
}
