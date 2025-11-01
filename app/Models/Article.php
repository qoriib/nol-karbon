<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image_path',
        'status',
        'submitted_at',
        'published_at',
        'needs_revision_at',
        'rejected_at',
        'tags',
        'meta',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'published_at' => 'datetime',
        'needs_revision_at' => 'datetime',
        'rejected_at' => 'datetime',
        'tags' => 'array',
        'meta' => 'array',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ArticleReview::class);
    }
}
