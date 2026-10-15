<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roadmap_topics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('roadmap_section_id')
                ->constrained('roadmap_sections')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug');

            $table->text('description')->nullable();

            $table->unsignedSmallInteger('estimated_minutes')
                ->nullable();

            $table->unsignedSmallInteger('target_week')
                ->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);

            $table->timestamps();

            $table->unique(['roadmap_section_id', 'slug']);

            $table->index([
                'roadmap_section_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadmap_topics');
    }
};
