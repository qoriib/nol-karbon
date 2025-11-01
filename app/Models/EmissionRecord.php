<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmissionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_id',
        'scope',
        'recorded_for',
        'emission_kg_co2',
        'reduction_kg_co2',
        'category',
        'source',
        'notes',
        'evidence_path',
        'recorded_by',
        'metadata',
    ];

    protected $casts = [
        'recorded_for' => 'date',
        'emission_kg_co2' => 'decimal:2',
        'reduction_kg_co2' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
