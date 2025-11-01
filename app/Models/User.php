<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'primary_community_id',
        'name',
        'username',
        'email',
        'password',
        'status',
        'phone',
        'avatar_path',
        'bio',
        'joined_at',
        'last_login_at',
        'preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'joined_at' => 'datetime',
            'last_login_at' => 'datetime',
            'preferences' => 'array',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function primaryCommunity(): BelongsTo
    {
        return $this->belongsTo(Community::class, 'primary_community_id');
    }

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class)
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

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function articleReviews(): HasMany
    {
        return $this->hasMany(ArticleReview::class, 'reviewer_id');
    }

    public function challengesCreated(): HasMany
    {
        return $this->hasMany(Challenge::class, 'created_by');
    }

    public function challengeParticipations(): HasMany
    {
        return $this->hasMany(ChallengeParticipant::class);
    }

    public function challenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class, 'challenge_participants')
            ->withPivot([
                'status',
                'progress_percentage',
                'points_earned',
                'joined_at',
                'completed_at',
                'last_reported_at',
                'metadata',
            ])
            ->withTimestamps();
    }

    public function emissionRecords(): HasMany
    {
        return $this->hasMany(EmissionRecord::class);
    }

    public function emissionCards(): HasMany
    {
        return $this->hasMany(EmissionCard::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class);
    }

    public function actionsPerformed(): HasMany
    {
        return $this->hasMany(UserActivity::class, 'performed_by');
    }
}

