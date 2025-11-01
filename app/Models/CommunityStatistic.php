<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'period_start',
        'period_end',
        'total_members',
        'active_members',
        'total_points',
        'total_emission_kg_co2',
        'average_monthly_emission_kg_co2',
        'challenge_participants_count',
        'active_challenges_count',
        'metadata',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_members' => 'integer',
        'active_members' => 'integer',
        'total_points' => 'integer',
        'total_emission_kg_co2' => 'decimal:2',
        'average_monthly_emission_kg_co2' => 'decimal:2',
        'challenge_participants_count' => 'integer',
        'active_challenges_count' => 'integer',
        'metadata' => 'array',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
