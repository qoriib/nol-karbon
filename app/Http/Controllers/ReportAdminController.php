<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeParticipant;
use App\Models\Community;
use App\Models\EmissionRecord;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportAdminController extends Controller
{
    public function index(): View
    {
        $communityEmissions = Community::query()
            ->select('id', 'name', 'total_emission_reduced', 'total_points')
            ->withAvg('emissionRecords as average_reduction', 'reduction_kg_co2')
            ->orderByDesc('total_emission_reduced')
            ->get()
            ->map(function ($community) {
                return [
                    'name' => $community->name,
                    'total_emission' => number_format((float) $community->total_emission_reduced, 1) . ' Kg CO₂',
                    'average_monthly' => number_format((float) ($community->average_reduction ?? 0), 1) . ' Kg CO₂',
                ];
            });

        $challengeParticipation = ChallengeParticipant::with(['user', 'challenge'])
            ->orderByDesc('points_earned')
            ->limit(8)
            ->get()
            ->map(function ($participant) {
                return [
                    'user' => $participant->user->name ?? 'Peserta',
                    'challenge' => $participant->challenge->title ?? '-',
                    'points' => $participant->points_earned,
                    'status' => ucfirst($participant->status),
                ];
            });

        return view('admin.reports.index', [
            'communityEmissions' => $communityEmissions,
            'challengeParticipation' => $challengeParticipation,
        ]);
    }

    public function activities(Request $request): View
    {
        $activities = UserActivity::with(['user:id,name,email', 'performedBy:id,name'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $summary = [
            'total_users' => User::count(),
            'total_reduction' => (float) EmissionRecord::sum('reduction_kg_co2'),
        ];

        $monthlyReductions = EmissionRecord::select(
            'user_id',
            DB::raw('YEAR(recorded_for) as year'),
            DB::raw('MONTH(recorded_for) as month_number'),
            DB::raw("DATE_FORMAT(recorded_for, '%b %Y') as month_label"),
            DB::raw('SUM(reduction_kg_co2) as total_reduction')
        )
            ->groupBy('user_id', 'year', 'month_number', 'month_label')
            ->orderBy('year', 'desc')
            ->orderBy('month_number', 'desc')
            ->get();

        $userDirectory = User::select('id', 'name')
            ->whereIn('id', $monthlyReductions->pluck('user_id')->unique())
            ->get()
            ->keyBy('id');

        $monthlyActivities = $monthlyReductions
            ->groupBy('user_id')
            ->map(function ($rows) use ($userDirectory) {
                return $rows
                    ->sortBy(fn ($row) => $row->year * 100 + $row->month_number)
                    ->values()
                    ->map(function ($row) use ($userDirectory) {
                        return (object) [
                            'month' => $row->month_label,
                            'total_reduction' => (float) $row->total_reduction,
                            'user' => $userDirectory->get($row->user_id),
                        ];
                    });
            });

        return view('admin.reports.activities', [
            'activities' => $activities,
            'summary' => $summary,
            'monthlyActivities' => $monthlyActivities,
        ]);
    }
}
