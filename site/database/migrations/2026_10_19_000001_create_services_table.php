<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('slug');
            $table->string('mode');
            $table->json('summary')->nullable();
            $table->json('body')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->json('turnaround')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('published')->default(false);
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->timestamps();
        });
        // ERD I3: unique per locale on the Spanish slug (functional index, MySQL 8).
        DB::statement("ALTER TABLE services ADD UNIQUE services_slug_es_unique ((CAST(slug->>'$.es' AS CHAR(255) CHARACTER SET utf8mb4)))");
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
