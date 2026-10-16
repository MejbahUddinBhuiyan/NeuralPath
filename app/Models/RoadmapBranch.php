<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadmapBranch extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'phase_number',
        'start_week',
        'end_week',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'phase_number' => 'integer',
            'start_week' => 'integer',
            'end_week' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(RoadmapSection::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
    public function recommendedProjects(): HasMany
{
    return $this->hasMany(RecommendedProject::class)
        ->orderBy('sort_order')
        ->orderBy('id');
}
}
