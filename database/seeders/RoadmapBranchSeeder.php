<?php

namespace Database\Seeders;

use App\Models\RoadmapBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoadmapBranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'phase_number' => 0,
                'title' => 'Software Engineering Foundations',
                'description' => 'Production Python, FastAPI, Pydantic, databases, Redis, Docker, testing, and CI fundamentals.',
                'start_week' => 1,
                'end_week' => 4,
            ],
            [
                'phase_number' => 1,
                'title' => 'LLM Engineering, RAG and Context Engineering',
                'description' => 'LLM APIs, structured outputs, embeddings, vector databases, retrieval pipelines, reranking, context management, and RAG evaluation.',
                'start_week' => 5,
                'end_week' => 12,
            ],
            [
                'phase_number' => 2,
                'title' => 'Core AI Agents and Agent Frameworks',
                'description' => 'Native agent loops, tool calling, agent design patterns, OpenAI Agents SDK, LangGraph, state, memory, and checkpointing.',
                'start_week' => 13,
                'end_week' => 22,
            ],
            [
                'phase_number' => 3,
                'title' => 'MCP, Integrations and Computer-Use Agents',
                'description' => 'Model Context Protocol, tool servers, authentication, A2A fundamentals, Playwright, browser automation, and isolated execution.',
                'start_week' => 23,
                'end_week' => 28,
            ],
            [
                'phase_number' => 4,
                'title' => 'Multi-Agent Systems',
                'description' => 'Supervisors, specialized agents, delegation, communication, shared state, parallel workflows, and multi-agent comparisons.',
                'start_week' => 29,
                'end_week' => 33,
            ],
            [
                'phase_number' => 5,
                'title' => 'Evaluation, Tracing and Reliability',
                'description' => 'Agent benchmarks, success metrics, tool accuracy, retrieval metrics, observability, tracing, latency, cost, and reliability.',
                'start_week' => 34,
                'end_week' => 39,
            ],
            [
                'phase_number' => 6,
                'title' => 'Safety, Security and Governance',
                'description' => 'Prompt injection, tool security, authorization, sandboxing, secrets management, audit logging, and security testing.',
                'start_week' => 40,
                'end_week' => 43,
            ],
            [
                'phase_number' => 7,
                'title' => 'Production, LLMOps and Scale',
                'description' => 'Deployment, Docker Compose, CI/CD, background jobs, monitoring, cloud infrastructure, recovery, and production reliability.',
                'start_week' => 44,
                'end_week' => 51,
            ],
            [
                'phase_number' => 8,
                'title' => 'Specialization and Flagship Project',
                'description' => 'Industry specialization, research and analytics agents, production capstone, benchmarking, portfolio development, and technical case studies.',
                'start_week' => 52,
                'end_week' => 60,
            ],
        ];

        foreach ($branches as $branch) {
            RoadmapBranch::updateOrCreate(
                [
                    'phase_number' => $branch['phase_number'],
                ],
                [
                    'title' => $branch['title'],
                    'slug' => Str::slug($branch['title']),
                    'description' => $branch['description'],
                    'start_week' => $branch['start_week'],
                    'end_week' => $branch['end_week'],
                    'sort_order' => $branch['phase_number'],
                ]
            );
        }

        $this->command?->info(
            'The nine Agentic AI roadmap phases were synchronized successfully.'
        );
    }
}
