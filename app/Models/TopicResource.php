<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicResource extends Model
{
    protected $fillable = [
        'roadmap_topic_id',
        'title',
        'url',
        'type',
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

    public function topic(): BelongsTo
    {
        return $this->belongsTo(
            RoadmapTopic::class,
            'roadmap_topic_id'
        );
    }
}
