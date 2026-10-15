<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadmapTopic extends Model
{
    protected $fillable = [
        'roadmap_section_id',
        'title',
        'slug',
        'description',
        'estimated_minutes',
        'target_week',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'estimated_minutes' => 'integer',
            'target_week' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(
            RoadmapSection::class,
            'roadmap_section_id'
        );
    }
}
