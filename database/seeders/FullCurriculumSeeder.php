<?php

namespace Database\Seeders;

use App\Models\RoadmapBranch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use RuntimeException;

class FullCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Each week contains two learning topics.
         * Each module also has an official reference resource.
         *
         * New sections, topics, and resources remain drafts.
         * Existing records and admin edits are preserved.
         */

        $curriculum = [

            // PHASE 1: WEEKS 5–12
            1 => [
                [
                    'LLM API Fundamentals',
                    'Build reliable applications using language model APIs.',
                    'OpenAI Platform Documentation',
                    'https://platform.openai.com/docs',
                    [
                        5 => ['LLM APIs and Model Selection', 'Tokens, Context Windows and Pricing'],
                        6 => ['Prompt Design and Message Roles', 'Structured Outputs and JSON Schemas'],
                        7 => ['Function Calling Fundamentals', 'Streaming and Error Handling'],
                    ],
                ],
                [
                    'Embeddings and Retrieval',
                    'Learn semantic search and retrieval infrastructure.',
                    'Sentence Transformers Documentation',
                    'https://sbert.net/',
                    [
                        8 => ['Embeddings and Vector Similarity', 'Chunking and Document Preparation'],
                        9 => ['Vector Databases and Indexing', 'Semantic Search and Metadata Filtering'],
                    ],
                ],
                [
                    'RAG and Context Engineering',
                    'Build retrieval-augmented applications and evaluate context quality.',
                    'LangChain Documentation',
                    'https://docs.langchain.com/',
                    [
                        10 => ['Basic RAG Pipeline', 'Hybrid Search and Reranking'],
                        11 => ['Context Assembly and Citation Grounding', 'Conversation History and Context Compression'],
                        12 => ['RAG Evaluation and Retrieval Metrics', 'RAG Mini Project'],
                    ],
                ],
            ],

            // PHASE 2: WEEKS 13–22
            2 => [
                [
                    'Agent Foundations',
                    'Understand reasoning loops, tool usage and agent behavior.',
                    'OpenAI Agents Documentation',
                    'https://openai.github.io/openai-agents-python/',
                    [
                        13 => ['What Makes a System an Agent', 'Agent Loop and Stop Conditions'],
                        14 => ['Tool Calling and Tool Schemas', 'Tool Error Handling and Retries'],
                        15 => ['Planning and Task Decomposition', 'ReAct and Agent Design Patterns'],
                    ],
                ],
                [
                    'Agent Frameworks',
                    'Implement framework-based and custom agent workflows.',
                    'LangGraph Documentation',
                    'https://docs.langchain.com/oss/python/langgraph/overview',
                    [
                        16 => ['Custom Agent Implementation', 'OpenAI Agents SDK Fundamentals'],
                        17 => ['LangGraph State and Nodes', 'Edges, Routing and Conditional Flows'],
                        18 => ['Persistent State and Checkpointing', 'Human-in-the-Loop Approvals'],
                        19 => ['Agent Memory Design', 'Agent Tools and Dependency Injection'],
                    ],
                ],
                [
                    'Practical Agent Engineering',
                    'Develop useful agents with testing and safe recovery.',
                    'OpenAI Agents Documentation',
                    'https://openai.github.io/openai-agents-python/',
                    [
                        20 => ['Research Agent Workflow', 'Coding Assistant Workflow'],
                        21 => ['Agent Failure Recovery', 'Agent Integration Testing'],
                        22 => ['End-to-End Agent Application', 'Agent Project Review and Refactoring'],
                    ],
                ],
            ],

            // PHASE 3: WEEKS 23–28
            3 => [
                [
                    'Model Context Protocol',
                    'Use standardized tool and resource integrations.',
                    'Model Context Protocol Documentation',
                    'https://modelcontextprotocol.io/',
                    [
                        23 => ['MCP Architecture and Concepts', 'MCP Tools, Resources and Prompts'],
                        24 => ['Build an MCP Server', 'Connect an MCP Client'],
                    ],
                ],
                [
                    'External Integrations',
                    'Connect agents to services while protecting permissions.',
                    'OAuth Documentation',
                    'https://www.oauth.com/',
                    [
                        25 => ['OAuth and API Authentication', 'Permission Scopes and Token Handling'],
                        26 => ['Agent-to-Agent Communication Concepts', 'Integration Timeouts and Rate Limits'],
                    ],
                ],
                [
                    'Computer Use and Automation',
                    'Build and test controlled browser and computer-use workflows.',
                    'Playwright Documentation',
                    'https://playwright.dev/',
                    [
                        27 => ['Playwright Browser Automation', 'Browser State and Session Management'],
                        28 => ['Computer-Use Safety and Isolation', 'Browser Automation Mini Project'],
                    ],
                ],
            ],

            // PHASE 4: WEEKS 29–33
            4 => [
                [
                    'Multi-Agent Architecture',
                    'Design and compare collaborative agent systems.',
                    'LangGraph Documentation',
                    'https://docs.langchain.com/oss/python/langgraph/overview',
                    [
                        29 => ['Single-Agent vs Multi-Agent Systems', 'Supervisor and Worker Patterns'],
                        30 => ['Agent Roles and Specialization', 'Agent Delegation and Routing'],
                    ],
                ],
                [
                    'Agent Collaboration',
                    'Coordinate multiple agents using clear communication.',
                    'OpenAI Agents Documentation',
                    'https://openai.github.io/openai-agents-python/',
                    [
                        31 => ['Agent Handoffs and Communication', 'Shared State and Conflict Resolution'],
                        32 => ['Parallel Agent Execution', 'Multi-Agent Failure Handling'],
                    ],
                ],
                [
                    'Multi-Agent Project',
                    'Evaluate a complete collaborative workflow.',
                    'LangGraph Documentation',
                    'https://docs.langchain.com/oss/python/langgraph/overview',
                    [
                        33 => ['Multi-Agent Research System', 'Multi-Agent Evaluation and Comparison'],
                    ],
                ],
            ],

            // PHASE 5: WEEKS 34–39
            5 => [
                [
                    'Agent Evaluation',
                    'Measure task quality, tool use and model behavior.',
                    'OpenAI Evals Repository',
                    'https://github.com/openai/evals',
                    [
                        34 => ['Evaluation Datasets and Golden Answers', 'Task Success and Failure Metrics'],
                        35 => ['Tool Calling Accuracy', 'Retrieval Precision and Recall'],
                    ],
                ],
                [
                    'Tracing and Observability',
                    'Understand agent execution and diagnose problems.',
                    'OpenTelemetry Documentation',
                    'https://opentelemetry.io/docs/',
                    [
                        36 => ['Tracing Agent Execution', 'Structured Logs and Correlation IDs'],
                        37 => ['Latency, Token Usage and Cost Metrics', 'Agent Debugging and Trace Analysis'],
                    ],
                ],
                [
                    'Reliability Engineering',
                    'Improve resilience through testing and controlled retries.',
                    'Pytest Documentation',
                    'https://docs.pytest.org/',
                    [
                        38 => ['Regression Tests and Failure Cases', 'Timeouts, Retries and Fallbacks'],
                        39 => ['Evaluation Automation', 'Reliability Improvement Project'],
                    ],
                ],
            ],

            // PHASE 6: WEEKS 40–43
            6 => [
                [
                    'AI Security Foundations',
                    'Understand attacks against LLM applications and agents.',
                    'OWASP LLM Security Project',
                    'https://genai.owasp.org/',
                    [
                        40 => ['Prompt Injection and Trust Boundaries', 'Indirect Prompt Injection'],
                        41 => ['Unsafe Tool Execution', 'Data Leakage and Sensitive Information'],
                    ],
                ],
                [
                    'Secure Agent Engineering',
                    'Apply authorization and isolation to autonomous workflows.',
                    'OWASP Cheat Sheet Series',
                    'https://cheatsheetseries.owasp.org/',
                    [
                        42 => ['Least Privilege and Authorization', 'Secrets Management and Sandboxing'],
                    ],
                ],
                [
                    'Governance and Security Testing',
                    'Build auditable systems and verify security controls.',
                    'NIST AI Risk Management Framework',
                    'https://www.nist.gov/itl/ai-risk-management-framework',
                    [
                        43 => ['Audit Logs and Human Approval', 'Threat Modeling and Security Testing'],
                    ],
                ],
            ],

            // PHASE 7: WEEKS 44–51
            7 => [
                [
                    'Deployment Foundations',
                    'Package and deploy AI applications.',
                    'Docker Documentation',
                    'https://docs.docker.com/',
                    [
                        44 => ['Production Docker Images', 'Docker Compose Architecture'],
                        45 => ['Environment Configuration and Secrets', 'Production API Deployment'],
                        46 => ['Reverse Proxies and HTTPS', 'Health Checks and Readiness'],
                    ],
                ],
                [
                    'Asynchronous Production Workflows',
                    'Operate reliable background and distributed workloads.',
                    'Celery Documentation',
                    'https://docs.celeryq.dev/',
                    [
                        47 => ['Background Jobs and Task Queues', 'Redis Queues and Workers'],
                        48 => ['Idempotency and Retry Policies', 'Scheduling and Long-Running Tasks'],
                    ],
                ],
                [
                    'LLMOps and Production Reliability',
                    'Manage deployment pipelines, scale and recovery.',
                    'GitHub Actions Documentation',
                    'https://docs.github.com/en/actions',
                    [
                        49 => ['CI/CD for Agent Applications', 'Model and Prompt Versioning'],
                        50 => ['Monitoring and Alerting', 'Scaling, Caching and Cost Optimization'],
                        51 => ['Backups and Disaster Recovery', 'Production Readiness Review'],
                    ],
                ],
            ],

            // PHASE 8: WEEKS 52–60
            8 => [
                [
                    'Specialization and Project Planning',
                    'Select an industry problem and establish measurable goals.',
                    'GitHub Project Documentation',
                    'https://docs.github.com/',
                    [
                        52 => ['Choose a Domain Specialization', 'Problem Definition and Requirements'],
                        53 => ['Dataset and Tool Selection', 'Architecture and Risk Assessment'],
                        54 => ['Project Milestones and Evaluation Plan', 'Baseline System Implementation'],
                    ],
                ],
                [
                    'Flagship Agent Project',
                    'Build and evaluate a production-oriented capstone.',
                    'OpenAI Agents Documentation',
                    'https://openai.github.io/openai-agents-python/',
                    [
                        55 => ['Agent Workflow Implementation', 'Tool and MCP Integration'],
                        56 => ['Persistent State and Memory', 'Authentication and Security Controls'],
                        57 => ['Automated Tests and Evaluations', 'Observability and Trace Collection'],
                        58 => ['Deployment and Performance Testing', 'Failure Analysis and Improvements'],
                    ],
                ],
                [
                    'Portfolio and Research Presentation',
                    'Document results and communicate engineering decisions.',
                    'GitHub Documentation',
                    'https://docs.github.com/',
                    [
                        59 => ['Technical Documentation and Case Study', 'Benchmark Results and Limitations'],
                        60 => ['Portfolio and Live Demonstration', 'Final Capstone Review and Future Roadmap'],
                    ],
                ],
            ],
        ];

        $createdSections = 0;
        $createdTopics = 0;
        $createdResources = 0;

        foreach ($curriculum as $phaseNumber => $modules) {
            $branch = RoadmapBranch::query()
                ->where('phase_number', $phaseNumber)
                ->first();

            if (! $branch) {
                throw new RuntimeException(
                    "Phase {$phaseNumber} is missing. "
                    . "Run RoadmapBranchSeeder first on a new database."
                );
            }

            foreach ($modules as $moduleIndex => $module) {
                [
                    $sectionTitle,
                    $description,
                    $resourceTitle,
                    $resourceUrl,
                    $weeks,
                ] = $module;

                $section = $branch->sections()->firstOrCreate(
                    ['slug' => Str::slug($sectionTitle)],
                    [
                        'title' => $sectionTitle,
                        'description' => $description,
                        'sort_order' => $moduleIndex + 1,
                        'is_published' => false,
                    ]
                );

                if ($section->wasRecentlyCreated) {
                    $createdSections++;
                }

                $topicOrder = 0;

                foreach ($weeks as $week => $titles) {
                    if (
                        $week < $branch->start_week ||
                        $week > $branch->end_week
                    ) {
                        throw new RuntimeException(
                            "Week {$week} is outside phase {$phaseNumber}."
                        );
                    }

                    foreach ($titles as $title) {
                        $topicOrder++;

                        $topic = $section->topics()->firstOrCreate(
                            ['slug' => Str::slug($title)],
                            [
                                'title' => $title,
                                'target_week' => (int) $week,
                                'estimated_minutes' => 120,
                                'sort_order' => $topicOrder,
                                'is_published' => false,
                            ]
                        );

                        if ($topic->wasRecentlyCreated) {
                            $createdTopics++;
                        }

                        // One starter reference per topic.
                        // Existing resources are never overwritten.
                        $resource = $topic->resources()->firstOrCreate(
                            [
                                'title' => $resourceTitle,
                                'url' => $resourceUrl,
                            ],
                            [
                                'type' => 'documentation',
                                'description' => 'Official reference material for this learning module.',
                                'sort_order' => 1,
                                'is_published' => false,
                            ]
                        );

                        if ($resource->wasRecentlyCreated) {
                            $createdResources++;
                        }
                    }
                }
            }
        }

        $this->command?->info(
            "Curriculum synchronized: {$createdSections} new modules, "
            . "{$createdTopics} new topics, "
            . "{$createdResources} new resources."
        );
    }
}
