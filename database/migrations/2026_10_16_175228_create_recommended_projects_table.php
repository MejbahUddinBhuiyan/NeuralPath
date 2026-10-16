
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A previous MySQL migration may have created the table
        // before failing on an automatically generated index name.
        // Preserve the existing table and seeded project records.

        if (! Schema::hasTable('recommended_projects')) {
            Schema::create('recommended_projects', function (Blueprint $table) {
                $table->id();

                $table->foreignId('roadmap_branch_id')
                    ->constrained('roadmap_branches')
                    ->cascadeOnDelete();

                $table->string('title');
                $table->string('slug');
                $table->text('description');

                $table->enum('difficulty', [
                    'beginner',
                    'intermediate',
                    'advanced',
                ])->default('intermediate');

                $table->string('estimated_weeks')->nullable();
                $table->text('tech_stack')->nullable();
                $table->longText('requirements')->nullable();
                $table->longText('deliverables')->nullable();
                $table->string('resource_url', 2048)->nullable();

                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_published')->default(false);

                $table->timestamps();

                $table->unique(
                    ['roadmap_branch_id', 'slug'],
                    'rp_branch_slug_unique'
                );
            });
        }

        // Short index name, compatible with MySQL.
        if (! Schema::hasIndex(
            'recommended_projects',
            'rp_branch_pub_order_idx'
        )) {
            Schema::table('recommended_projects', function (Blueprint $table) {
                $table->index(
                    ['roadmap_branch_id', 'is_published', 'sort_order'],
                    'rp_branch_pub_order_idx'
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('recommended_projects');
    }
};