<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructions',
        'point_reward',
        'bonus_point',
        'start_date',
        'end_date',
        'status',
        'visibility',
        'max_participants',
        'created_by',
        'cover_image_path',
        'requirements',
        'metadata',
    ];

    protected $casts = [
        'point_reward' => 'integer',
        'bonus_point' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'requirements' => 'array',
        'metadata' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ChallengeParticipant::class);
    }

    public function progressLogs(): HasManyThrough
    {
        return $this->hasManyThrough(
            ChallengeProgressLog::class,
            ChallengeParticipant::class
        );
    }
}
