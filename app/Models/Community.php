<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'tagline',
        'description',
        'logo_path',
        'cover_image_path',
        'contact_email',
        'contact_phone',
        'website_url',
        'city',
        'province',
        'created_by',
        'status',
        'total_members',
        'total_points',
        'total_emission_reduced',
        'metadata',
    ];

    protected $casts = [
        'total_members' => 'integer',
        'total_points' => 'integer',
        'total_emission_reduced' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot([
                'role',
                'status',
                'points_accumulated',
                'joined_at',
                'left_at',
                'metadata',
            ])
            ->withTimestamps();
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(CommunityStatistic::class);
    }

    public function emissionRecords(): HasMany
    {
        return $this->hasMany(EmissionRecord::class);
    }
}
