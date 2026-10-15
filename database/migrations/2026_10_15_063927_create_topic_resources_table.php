
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_resources', function (Blueprint $table) {
            $table->id();

            $table->foreignId('roadmap_topic_id')
                ->constrained('roadmap_topics')
                ->cascadeOnDelete();

            $table->string('title', 180);
            $table->string('url', 2048);

            $table->enum('type', [
                'documentation',
                'youtube',
                'article',
                'course',
                'other',
            ])->default('documentation');

            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_published')
                ->default(false);

            $table->timestamps();

            $table->index([
                'roadmap_topic_id',
                'is_published',
                'sort_order',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_resources');
    }
};
