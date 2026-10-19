<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->json('excerpt')->nullable();
            $table->json('body');
            $table->string('cover')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->timestamps();
        });
        // ERD I3: unique per locale on the Spanish slug (functional index, MySQL 8).
        DB::statement("ALTER TABLE posts ADD UNIQUE posts_slug_es_unique ((CAST(slug->>'$.es' AS CHAR(255) CHARACTER SET utf8mb4)))");
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
