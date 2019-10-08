<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use Sluggable;

    protected $fillable = [
        'url',
        'name',
        'description',
        'category_id',
        'is_pending',
        'is_premium',
    ];

    protected $casts = [
        'is_pending' => 'boolean',
        'is_premium' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ImageUpload::class, 'game_id', 'id');
    }

    public function scopeFindBySlug($query, $slug): Game
    {
        return $query->whereSlug($slug)->firstOrFail();
    }

    public function scopeVotesIn($query): HasMany
    {
        return $this->hasMany(Vote::class, 'id', 'game_id')
            ->whereType('in');
    }

    public function scopeVotesOut($query): HasMany
    {
        return $this->hasMany(Vote::class, 'id', 'game_id')
            ->whereType('out');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
