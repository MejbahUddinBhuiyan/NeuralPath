<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendedProject extends Model
{
    protected $fillable = [
        'roadmap_branch_id',
        'title',
        'slug',
        'description',
        'difficulty',
        'estimated_weeks',
        'tech_stack',
        'requirements',
        'deliverables',
        'resource_url',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(
            RoadmapBranch::class,
            'roadmap_branch_id'
        );
    }
}
