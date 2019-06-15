<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use Sluggable;

    protected $fillable = [
        'url',
        'name',
        'description',
        'category',
        'is_pending',
        'is_premium',
    ];

    protected $casts = [
        'is_pending'   =>  'boolean',
        'is_premium'   =>  'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
