<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChallengeParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'user_id',
        'status',
        'progress_percentage',
        'points_earned',
        'joined_at',
        'completed_at',
        'last_reported_at',
        'metadata',
    ];

    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'points_earned' => 'integer',
        'joined_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_reported_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function progressLogs(): HasMany
    {
        return $this->hasMany(ChallengeProgressLog::class);
    }
}
