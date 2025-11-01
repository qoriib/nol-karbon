<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeProgressLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_participant_id',
        'logged_for',
        'activity_type',
        'description',
        'metric_value',
        'metric_unit',
        'attachments',
        'metadata',
    ];

    protected $casts = [
        'logged_for' => 'date',
        'metric_value' => 'decimal:2',
        'attachments' => 'array',
        'metadata' => 'array',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(ChallengeParticipant::class, 'challenge_participant_id');
    }
}
