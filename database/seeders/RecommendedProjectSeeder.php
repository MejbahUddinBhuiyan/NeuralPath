<?php

namespace Database\Seeders;

use App\Models\RoadmapBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class RecommendedProjectSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Each project:
         * [title, difficulty, duration, technology stack, goal]
         *
         * Five recommendations for each of the nine phases.
         * Newly created records are drafts.
         */
        $projects = [
            0 => [
                [
                    'LLM API Gateway',
                    'intermediate',
                    '2–3 weeks',
                    'Python, FastAPI, Pydantic, Docker, pytest',
                    'Build a tested, authenticated API gateway with model integration, streaming, retries and request logging.',
                ],
                [
                    'Async Task Processing API',
                    'intermediate',
                    '1–2 weeks',
                    'Python, asyncio, FastAPI, Redis',
                    'Build an asynchronous API that handles long-running tasks with status tracking and reliable error handling.',
                ],
                [
                    'Production REST API Starter',
                    'beginner',
                    '1–2 weeks',
                    'FastAPI, PostgreSQL, SQLAlchemy, Pydantic',
                    'Create a reusable backend template with authentication, database migrations, validation and tests.',
                ],
                [
                    'Containerized Background Job Service',
                    'intermediate',
                    '2 weeks',
                    'Docker Compose, Redis, Python, PostgreSQL',
                    'Build a containerized worker system with retries, idempotency and job monitoring.',
                ],
                [
                    'Automated API Quality Pipeline',
                    'beginner',
                    '1 week',
                    'pytest, GitHub Actions, FastAPI',
                    'Create automated unit, integration and API-contract tests with continuous integration.',
                ],
            ],

            1 => [
                [
                    'ResearchPaper RAG Benchmark',
                    'advanced',
                    '3–4 weeks',
                    'Python, FastAPI, PostgreSQL, pgvector, Ragas',
                    'Build a citation-grounded research assistant and compare chunking, retrieval, reranking, accuracy and cost.',
                ],
                [
                    'Multi-Document AI Knowledge Assistant',
                    'intermediate',
                    '2–3 weeks',
                    'Python, LangChain, pgvector, FastAPI',
                    'Answer questions across uploaded documents while showing source citations and document-level permissions.',
                ],
                [
                    'Hybrid Search Evaluation Lab',
                    'advanced',
                    '2–3 weeks',
                    'PostgreSQL, BM25, embeddings, reranking',
                    'Benchmark dense retrieval, keyword search and hybrid retrieval using the same evaluation dataset.',
                ],
                [
                    'Structured LLM Data Extraction API',
                    'intermediate',
                    '2 weeks',
                    'FastAPI, Pydantic, LLM APIs, pytest',
                    'Extract validated structured information from unstructured text with schema checks and automated tests.',
                ],
                [
                    'Context-Aware Support Assistant',
                    'intermediate',
                    '2–3 weeks',
                    'Python, Redis, RAG, LLM APIs',
                    'Build a support assistant with conversation context, document search and token-budget controls.',
                ],
            ],

            2 => [
                [
                    'Autonomous Research Agent',
                    'advanced',
                    '4–5 weeks',
                    'Python, OpenAI Agents SDK, LangGraph, FastAPI',
                    'Implement a research agent with tools, source verification, checkpoints, recovery and a comparative evaluation.',
                ],
                [
                    'From-Scratch Tool-Using Agent',
                    'intermediate',
                    '2–3 weeks',
                    'Python, LLM APIs, Pydantic, pytest',
                    'Build an agent execution loop without a framework, including tool validation, limits and stopping conditions.',
                ],
                [
                    'Stateful LangGraph Workflow',
                    'intermediate',
                    '2–3 weeks',
                    'LangGraph, PostgreSQL, Python',
                    'Create a resumable agent workflow using graph state, checkpointing and human approvals.',
                ],
                [
                    'AI Coding Assistant',
                    'advanced',
                    '3–4 weeks',
                    'Python, Git, agent tools, Docker',
                    'Build an assistant that proposes code changes, runs authorized tests and explains its results.',
                ],
                [
                    'Agent Memory Comparison Lab',
                    'advanced',
                    '3 weeks',
                    'LangGraph, Redis, PostgreSQL, embeddings',
                    'Compare stateless agents, session memory and persistent memory using repeatable tasks.',
                ],
            ],

            3 => [
                [
                    'Developer Productivity MCP Server',
                    'advanced',
                    '3–4 weeks',
                    'MCP Python SDK, GitHub API, FastAPI, pytest',
                    'Expose authorized developer tools through an MCP server with scoped permissions and structured errors.',
                ],
                [
                    'Database Query MCP Toolkit',
                    'intermediate',
                    '2–3 weeks',
                    'MCP SDK, PostgreSQL, SQLAlchemy',
                    'Create read-only database tools with schema discovery, query limits and authorization controls.',
                ],
                [
                    'Browser Research Automation Agent',
                    'advanced',
                    '3–4 weeks',
                    'Playwright, Python, LLM APIs',
                    'Build a controlled browser agent that searches approved sites, extracts evidence and records traces.',
                ],
                [
                    'Secure File Analysis MCP Server',
                    'intermediate',
                    '2–3 weeks',
                    'MCP SDK, Python, file parsers',
                    'Build document-inspection tools restricted to approved directories and validated file types.',
                ],
                [
                    'Connected Tool Workflow Benchmark',
                    'advanced',
                    '3 weeks',
                    'MCP, Playwright, pytest, OpenTelemetry',
                    'Measure reliability, latency and failure recovery across connected agent tools.',
                ],
            ],

            4 => [
                [
                    'Multi-Agent Research Benchmark',
                    'advanced',
                    '3–4 weeks',
                    'LangGraph, Python, evaluation datasets',
                    'Compare one tool-using agent, a sequential specialist workflow and a parallel multi-agent team.',
                ],
                [
                    'Supervisor and Specialist Agent System',
                    'advanced',
                    '3–4 weeks',
                    'LangGraph, OpenAI Agents SDK, FastAPI',
                    'Build a supervisor that delegates tasks to specialized agents and validates their outputs.',
                ],
                [
                    'Collaborative Data Analysis Agents',
                    'advanced',
                    '3 weeks',
                    'Python, SQL, Pandas, LangGraph',
                    'Coordinate data retrieval, analysis and review agents to produce evidence-backed reports.',
                ],
                [
                    'Multi-Agent Conflict Resolution Lab',
                    'advanced',
                    '2–3 weeks',
                    'Python, LangGraph, PostgreSQL',
                    'Investigate conflicting agent recommendations and implement deterministic resolution policies.',
                ],
                [
                    'Parallel Research and Review Pipeline',
                    'intermediate',
                    '2–3 weeks',
                    'Python, async workflows, LLM APIs',
                    'Build parallel research workers and a reviewer that checks evidence before producing a report.',
                ],
            ],

            5 => [
                [
                    'Agent Evaluation Harness',
                    'advanced',
                    '3–4 weeks',
                    'Python, pytest, Ragas, OpenTelemetry',
                    'Build an evaluation runner for task success, tool accuracy, latency, cost and regressions.',
                ],
                [
                    'Agent Tracing Dashboard',
                    'intermediate',
                    '2–3 weeks',
                    'FastAPI, OpenTelemetry, PostgreSQL',
                    'Create a dashboard for inspecting agent executions, tool calls, failures and execution time.',
                ],
                [
                    'RAG Groundedness Test Suite',
                    'intermediate',
                    '2 weeks',
                    'Python, Ragas, pytest',
                    'Evaluate whether generated answers are supported by retrieved evidence and contain accurate citations.',
                ],
                [
                    'Agent Failure Recovery Benchmark',
                    'advanced',
                    '3 weeks',
                    'Python, LangGraph, Docker, pytest',
                    'Inject controlled tool failures and compare retry, fallback and checkpoint-recovery strategies.',
                ],
                [
                    'LLM Cost and Latency Optimizer',
                    'advanced',
                    '2–3 weeks',
                    'Python, model APIs, Redis, metrics',
                    'Compare caching, model selection and token-budget strategies under a fixed quality requirement.',
                ],
            ],

            6 => [
                [
                    'Agent Security Red-Team Lab',
                    'advanced',
                    '3–4 weeks',
                    'Python, Docker, OWASP, pytest',
                    'Create an authorized test environment for prompt-injection attempts, tool misuse and defensive regression tests.',
                ],
                [
                    'Prompt Injection Defense Benchmark',
                    'advanced',
                    '2–3 weeks',
                    'Python, LLM APIs, test datasets',
                    'Evaluate trust-boundary enforcement and resistance to malicious retrieved content.',
                ],
                [
                    'Permission-Aware Agent Gateway',
                    'intermediate',
                    '2–3 weeks',
                    'FastAPI, OAuth, PostgreSQL, Python',
                    'Build a gateway that validates user permissions before agent tools can execute operations.',
                ],
                [
                    'Secure Tool Execution Sandbox',
                    'advanced',
                    '3–4 weeks',
                    'Docker, Python, Linux security',
                    'Run approved operations in an isolated environment with time limits and restricted access.',
                ],
                [
                    'AI Audit and Governance Dashboard',
                    'intermediate',
                    '2–3 weeks',
                    'FastAPI, PostgreSQL, audit logging',
                    'Track agent actions, approvals, permission decisions and security-relevant events.',
                ],
            ],

            7 => [
                [
                    'Production Agent Deployment Platform',
                    'advanced',
                    '4–5 weeks',
                    'Docker, FastAPI, Redis, GitHub Actions',
                    'Deploy an authenticated agent service with tracing, queues, monitoring and repeatable release procedures.',
                ],
                [
                    'Scalable Agent Job Queue',
                    'advanced',
                    '3 weeks',
                    'Redis, Celery, Python, PostgreSQL',
                    'Process long-running agent tasks with retries, worker scaling and durable status tracking.',
                ],
                [
                    'LLMOps Monitoring Dashboard',
                    'intermediate',
                    '2–3 weeks',
                    'OpenTelemetry, FastAPI, PostgreSQL',
                    'Monitor request latency, model cost, failures and agent task success over time.',
                ],
                [
                    'AI Service CI/CD Pipeline',
                    'intermediate',
                    '2 weeks',
                    'GitHub Actions, Docker, pytest',
                    'Create automated test, build and deployment workflows with safe release and rollback steps.',
                ],
                [
                    'Production Reliability Stress Lab',
                    'advanced',
                    '3–4 weeks',
                    'Docker, load testing, Redis, metrics',
                    'Evaluate agent service performance under load, tool outages and rate-limit failures.',
                ],
            ],

            8 => [
                [
                    'AgentOps Research and Analytics Platform',
                    'advanced',
                    '6–8 weeks',
                    'React, FastAPI, LangGraph, MCP, PostgreSQL',
                    'Build a flagship research and data-analysis platform with approvals, tracing and evaluations.',
                ],
                [
                    'Self-Healing AI Agent System',
                    'advanced',
                    '5–7 weeks',
                    'LangGraph, Python, evaluation, PostgreSQL',
                    'Design a risk-aware agent that detects failing steps and selects safe recovery strategies.',
                ],
                [
                    'Budget-Aware Multi-Agent Orchestrator',
                    'advanced',
                    '5–7 weeks',
                    'LangGraph, Python, Redis, metrics',
                    'Coordinate specialist agents while optimizing task success, latency and token cost.',
                ],
                [
                    'Autonomous Research Reproduction Lab',
                    'advanced',
                    '6–8 weeks',
                    'Python, research benchmarks, agent tools',
                    'Build an agent-assisted system for implementing and evaluating reproducible research experiments.',
                ],
                [
                    'Self-Correcting Enterprise Data Agent',
                    'advanced',
                    '5–7 weeks',
                    'FastAPI, PostgreSQL, LangGraph, SQL',
                    'Build a governed data-analysis agent with query validation, evidence checking and recovery.',
                ],
            ],
        ];

        $created = 0;

        foreach ($projects as $phaseNumber => $phaseProjects) {
            if (count($phaseProjects) !== 5) {
                throw new RuntimeException(
                    "Phase {$phaseNumber} must have exactly five projects."
                );
            }

            $branch = RoadmapBranch::query()
                ->where('phase_number', $phaseNumber)
                ->firstOrFail();

            foreach ($phaseProjects as $index => $item) {
                [
                    $title,
                    $difficulty,
                    $duration,
                    $techStack,
                    $goal,
                ] = $item;

                $project = $branch->recommendedProjects()
                    ->firstOrCreate(
                        [
                            'slug' => Str::slug($title),
                        ],
                        [
                            'title' => $title,
                            'description' => $goal,
                            'difficulty' => $difficulty,
                            'estimated_weeks' => $duration,
                            'tech_stack' => $techStack,
                            'requirements' =>
                                "1. Define the problem and target users.\n"
                                . "2. Design and implement the core system.\n"
                                . "3. Add error handling, security and tests.\n"
                                . "4. Evaluate the result using measurable criteria.\n"
                                . "5. Document limitations and future improvements.",
                            'deliverables' =>
                                "1. Working source code in a GitHub repository.\n"
                                . "2. Setup instructions and environment example.\n"
                                . "3. Architecture description.\n"
                                . "4. Automated test results.\n"
                                . "5. Demo and evaluation report.",
                            'sort_order' => $index + 1,
                            'is_published' => false,
                        ]
                    );

                if ($project->wasRecentlyCreated) {
                    $created++;
                }
            }
        }

        $this->command?->info(
            "Recommended projects synchronized: {$created} new projects."
        );
    }
}
