<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChallengeAdminController extends Controller
{
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
