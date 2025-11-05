<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function dashboard(): View
    {
        $topPerformers = DB::table('community_user')
            ->join('users', 'community_user.user_id', '=', 'users.id')
            ->join('communities', 'community_user.community_id', '=', 'communities.id')
            ->select([
                'users.name as member_name',
                'communities.name as community_name',
                'community_user.points_accumulated',
            ])
            ->orderByDesc('community_user.points_accumulated')
            ->limit(12)
            ->get();

        $entries = $topPerformers->map(function ($row, $index) {
            return [
                'rank' => $index + 1,
                'member' => $row->member_name,
                'community' => $row->community_name,
                'points' => (int) $row->points_accumulated,
            ];
        });

        return view('communities.dashboard', [
            'entries' => $entries,
        ]);
    }
}
