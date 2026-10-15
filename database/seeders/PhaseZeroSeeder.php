<?php

namespace Database\Seeders;

use App\Models\RoadmapBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class PhaseZeroSeeder extends Seeder
{
    public function run(): void
    {
        $branch = RoadmapBranch::where('phase_number', 0)
            ->first();

        if (! $branch) {
            throw new RuntimeException(
                'Phase 0 does not exist. Run RoadmapBranchSeeder first.'
            );
        }

        $sections = [
            [
                'title' => 'Python Engineering',
                'description' => 'Production Python fundamentals for building reliable AI applications.',
                'topics' => [
                    ['Python Type Hints', 1, 90],
                    ['Exception Handling', 1, 90],
                    ['Asyncio and Asynchronous Execution', 1, 120],
                    ['Async and Await', 1, 120],
                ],
            ],
            [
                'title' => 'Pydantic and FastAPI',
                'description' => 'Data validation and production-ready API development.',
                'topics' => [
                    ['Pydantic Models and Validation', 2, 120],
                    ['FastAPI Endpoints', 2, 120],
                    ['Request and Response Models', 2, 90],
                    ['FastAPI Streaming Responses', 2, 90],
                ],
            ],
            [
                'title' => 'Databases and Caching',
                'description' => 'Persistent storage, relational data access, and caching.',
                'topics' => [
                    ['PostgreSQL Fundamentals', 3, 120],
                    ['SQLAlchemy ORM', 3, 120],
                    ['Redis Fundamentals', 3, 90],
                ],
            ],
            [
                'title' => 'Containers and Testing',
                'description' => 'Reliable environments and automated software testing.',
                'topics' => [
                    ['Docker Fundamentals', 3, 120],
                    ['Environment Management', 3, 60],
                    ['Pytest Fundamentals', 4, 90],
                    ['Mocking External Dependencies', 4, 90],
                    ['API Integration Tests', 4, 120],
                ],
            ],
            [
                'title' => 'Git and CI/CD',
                'description' => 'Collaborative version control and automated testing workflows.',
                'topics' => [
                    ['Git Branching', 4, 60],
                    ['GitHub Actions', 4, 120],
                    ['Continuous Integration Basics', 4, 90],
                ],
            ],
        ];

        foreach ($sections as $sectionIndex => $sectionData) {
            $section = $branch->sections()->updateOrCreate(
                [
                    'slug' => Str::slug($sectionData['title']),
                ],
                [
                    'title' => $sectionData['title'],
                    'description' => $sectionData['description'],
                    'sort_order' => $sectionIndex + 1,
                ]
            );

            foreach ($sectionData['topics'] as $topicIndex => $topicData) {
                [$title, $week, $minutes] = $topicData;

                $section->topics()->updateOrCreate(
                    [
                        'slug' => Str::slug($title),
                    ],
                    [
                        'title' => $title,
                        'target_week' => $week,
                        'estimated_minutes' => $minutes,
                        'sort_order' => $topicIndex + 1,
                    ]
                );
            }
        }

        $this->command?->info(
            'Phase 0 synchronized: 5 sections and 19 topics.'
        );
    }
}
