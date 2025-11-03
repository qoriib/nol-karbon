<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Challenge;
use App\Models\Community;
use App\Models\EmissionCard;
use App\Models\EmissionRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ChallengeAdminController extends Controller
{
    public function dashboard(): View
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $totalUsers = User::count();
        $newUsers = User::where('created_at', '>=', $startOfMonth)->count();

        $activeCommunities = Community::where('status', 'active')->count();
        $newCommunities = Community::where('status', 'active')
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        $activeChallenges = Challenge::where('status', 'active')->count();
        $newActiveChallenges = Challenge::where('status', 'active')
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        $totalReduction = (float) EmissionRecord::sum('reduction_kg_co2');
        $reductionThisMonth = (float) EmissionRecord::whereDate('recorded_for', '>=', $startOfMonth)
            ->sum('reduction_kg_co2');

        $overview = [
            [
                'label' => 'TOTAL USERS',
                'value' => number_format($totalUsers),
                'subtitle' => 'Pengguna terdaftar Nol Karbon.',
                'icon' => 'fa-solid fa-users',
                'delta' => $this->formatDeltaLabel($newUsers, 'NEW USERS'),
            ],
            [
                'label' => 'ACTIVE COMMUNITIES',
                'value' => number_format($activeCommunities),
                'subtitle' => 'Komunitas kampus & organisasi mitra aktif.',
                'icon' => 'fa-solid fa-building-columns',
                'delta' => $this->formatDeltaLabel($newCommunities, 'NEW COMMUNITIES'),
            ],
            [
                'label' => 'LIVE CHALLENGES',
                'value' => number_format($activeChallenges),
                'subtitle' => 'Tantangan lingkungan yang sedang berjalan.',
                'icon' => 'fa-solid fa-bullhorn',
                'delta' => $this->formatDeltaLabel($newActiveChallenges, 'NEW CHALLENGES'),
            ],
            [
                'label' => 'TOTAL CO₂ CUT',
                'value' => number_format($totalReduction, 1) . ' kg',
                'subtitle' => 'Akumulasi reduksi karbon terlapor.',
                'icon' => 'fa-solid fa-leaf',
                'delta' => $this->formatDeltaLabel($reductionThisMonth, 'KG THIS MONTH'),
            ],
        ];

        $totalEmissionCards = EmissionCard::count();

        $draftStats = [
            'submitted' => Article::count(),
            'unreviewed' => Article::whereIn('status', ['draft', 'pending_review'])->count(),
            'approved' => Article::where('status', 'published')->count(),
        ];

        $emissionTrend = $this->buildEmissionTrend();

        return view('admin.dashboard', [
            'overview' => $overview,
            'totalEmissionCards' => $totalEmissionCards,
            'draftStats' => $draftStats,
            'emissionTrend' => $emissionTrend,
        ]);
    }

    public function index(Request $request)
    {
        $status = $request->string('status')->trim();
        $status = $status->isNotEmpty() ? $status->toString() : null;

        $search = $request->string('q')->trim();
        $search = $search->isNotEmpty() ? $search->toString() : null;

        $challenges = Challenge::query()
            ->withCount('participants')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(fn ($subQuery) => $subQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%"));
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.challenges.index', [
            'challenges' => $challenges,
            'filters' => [
                'status' => $status,
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        return view('admin.challenges.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateChallenge($request);

        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('challenges', 'public');
        }

        unset($validated['cover_image']);

        $challenge = Challenge::create(array_merge($validated, [
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'requirements' => $this->normalizeRequirements($validated['requirements'] ?? null),
            'metadata' => [
                'created_via_admin' => true,
            ],
            'created_by' => Auth::id(),
            'cover_image_path' => $coverImagePath,
        ]));

        return redirect()
            ->route('admin.challenges.show', $challenge)
            ->with('status', 'Tantangan berhasil dibuat.');
    }

    public function show(Challenge $challenge)
    {
        $challenge->load([
            'creator',
            'participants.user',
        ])->loadCount('participants');

        return view('admin.challenges.show', [
            'challenge' => $challenge,
        ]);
    }

    public function edit(Challenge $challenge)
    {
        return view('admin.challenges.edit', [
            'challenge' => $challenge,
        ]);
    }

    public function update(Request $request, Challenge $challenge)
    {
        $validated = $this->validateChallenge($request, $challenge->id);

        $data = array_merge(
            collect($validated)->except('cover_image')->toArray(),
            [
            'requirements' => $this->normalizeRequirements($validated['requirements'] ?? null),
        ]);

        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('challenges', 'public');
            $data['cover_image_path'] = $coverImagePath;
        }

        $challenge->update($data);

        return redirect()
            ->route('admin.challenges.show', $challenge)
            ->with('status', 'Tantangan berhasil diperbarui.');
    }

    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return redirect()
            ->route('admin.challenges.index')
            ->with('status', 'Tantangan berhasil dihapus.');
    }

    private function formatDeltaLabel(float $value, string $suffix): string
    {
        if ($value <= 0) {
            return 'STABLE';
        }

        $decimals = fmod($value, 1.0) > 0 ? 1 : 0;

        return strtoupper(sprintf('+%s %s', number_format($value, $decimals), $suffix));
    }

    private function buildEmissionTrend(): Collection
    {
        return EmissionRecord::selectRaw('DATE_FORMAT(recorded_for, "%Y-%m-01") as period')
            ->selectRaw('DATE_FORMAT(recorded_for, "%b %Y") as label')
            ->selectRaw('SUM(emission_kg_co2) as total_emission')
            ->selectRaw('SUM(reduction_kg_co2) as total_reduction')
            ->groupBy('period', 'label')
            ->orderBy('period', 'desc')
            ->limit(6)
            ->get()
            ->sortBy('period')
            ->map(function ($row) {
                return (object) [
                    'month' => $row->label,
                    'total_emission' => (float) $row->total_emission,
                    'total_reduction' => (float) $row->total_reduction,
                ];
            })
            ->values();
    }

    private function validateChallenge(Request $request, ?int $challengeId = null): array
    {
        $uniqueSlugRule = 'unique:challenges,slug';
        if ($challengeId) {
            $uniqueSlugRule .= ',' . $challengeId;
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $uniqueSlugRule],
            'description' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
            'point_reward' => ['required', 'integer', 'min:0'],
            'bonus_point' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:draft,upcoming,active,completed,archived'],
            'visibility' => ['required', 'in:public,private'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'requirements' => ['nullable'],
            'metadata' => ['nullable', 'array'],
        ]);
    }

    private function normalizeRequirements(mixed $raw): ?array
    {
        if (is_array($raw)) {
            return array_values(array_filter($raw, fn ($value) => filled($value)));
        }

        if (is_string($raw)) {
            return collect(preg_split('/\r\n|\r|\n/', $raw))
                ->filter(fn ($value) => filled(trim($value)))
                ->values()
                ->all();
        }

        return null;
    }
}
