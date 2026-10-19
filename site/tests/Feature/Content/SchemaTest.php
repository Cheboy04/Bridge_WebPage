<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · test 1
// Columns come from docs/erd/modelo-contenido.md §3.

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('creates the content tables with the ERD columns', function (string $table, array $columns) {
    expect(Schema::hasTable($table))->toBeTrue()
        ->and(Schema::hasColumns($table, $columns))->toBeTrue();
})->with([
    'services' => ['services', ['id', 'title', 'slug', 'mode', 'summary', 'body', 'icon', 'image', 'turnaround', 'featured', 'sort', 'published', 'seo_title', 'seo_description', 'created_at', 'updated_at']],
    'languages' => ['languages', ['id', 'code', 'name', 'featured', 'sort', 'published', 'created_at', 'updated_at']],
    'language_service' => ['language_service', ['language_id', 'service_id']],
    'faqs' => ['faqs', ['id', 'question', 'answer', 'service_id', 'sort', 'created_at', 'updated_at']],
    'posts' => ['posts', ['id', 'title', 'slug', 'excerpt', 'body', 'cover', 'published_at', 'seo_title', 'seo_description', 'created_at', 'updated_at']],
    'clients' => ['clients', ['id', 'name', 'logo', 'url', 'sector', 'logo_permission', 'sort', 'created_at', 'updated_at']],
    'testimonials' => ['testimonials', ['id', 'quote', 'person', 'role', 'company', 'client_id', 'published', 'created_at', 'updated_at']],
    'pages' => ['pages', ['id', 'title', 'slug', 'body', 'seo_title', 'seo_description', 'created_at', 'updated_at']],
    'users.role' => ['users', ['role']],
]);
