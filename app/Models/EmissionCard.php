<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmissionCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_number',
        'status',
        'total_emission_kg_co2',
        'total_reduction_kg_co2',
        'summary',
        'qr_code_path',
        'issued_at',
        'expires_at',
        'metadata',
    ];

    protected $casts = [
        'total_emission_kg_co2' => 'decimal:2',
        'total_reduction_kg_co2' => 'decimal:2',
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
