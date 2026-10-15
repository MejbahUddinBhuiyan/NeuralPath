<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roadmap_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('roadmap_branch_id')
                ->constrained('roadmap_branches')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('slug');

            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(false);

            $table->timestamps();

            $table->unique(['roadmap_branch_id', 'slug']);

            $table->index([
                'roadmap_branch_id',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadmap_sections');
    }
};
