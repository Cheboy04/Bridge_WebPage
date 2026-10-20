<?php

// BRG-17 (brg-06) · spec docs/specs/brg-06.md §4 · test 5

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('sanitises the post body on save', function () {
    $post = Post::factory()->create(['body' => ['es' => '<p onclick="robar()">Texto <strong>claro</strong> '
        .'<a href="https://example.test/guia">guía</a> <a href="javascript:robar()">trampa</a></p>'
        .'<script>robar()</script>']]);

    $body = $post->fresh()->body;

    expect($body)
        ->toContain('<strong>claro</strong>')
        ->toContain('href="https://example.test/guia"')
        ->not->toContain('<script')
        ->not->toContain('onclick')
        ->not->toContain('javascript:');
});
