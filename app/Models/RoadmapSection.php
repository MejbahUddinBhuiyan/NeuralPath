<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadmapSection extends Model
{
    protected $fillable = [
        'roadmap_branch_id',
        'title',
        'slug',
        'description',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            RoadmapBranch::class,
            'roadmap_branch_id'
        );
    }

    public function topics(): HasMany
    {
        return $this->hasMany(RoadmapTopic::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
