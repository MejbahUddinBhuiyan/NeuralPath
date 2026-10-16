<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function resources(): HasMany
{
    return $this->hasMany(
        TopicResource::class,
        'roadmap_topic_id'
    )
        ->orderBy('sort_order')
        ->orderBy('id');
}

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
    public function progressRecords(): HasMany
{
    return $this->hasMany(
        TopicProgress::class,
        'roadmap_topic_id'
    );
}
}
