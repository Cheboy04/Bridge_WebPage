<?php

// BRG-5 (brg-31) · spec docs/specs/brg-31.md §4 · test 6

it('self-hosts the fonts', function () {
    $this->get('/')
        ->assertOk()
        ->assertDontSee('fonts.googleapis.com')
        ->assertDontSee('fonts.gstatic.com');

    preg_match_all('/@font-face\s*\{[^}]*\}/', (string) file_get_contents(resource_path('css/app.css')), $faces);
    preg_match_all('/url\([\'"]?([^\'")]+)[\'"]?\)/', implode("\n", $faces[0]), $urls);

    expect($urls[1])->not->toBeEmpty();

    foreach ($urls[1] as $url) {
        expect($url)->toStartWith('/fonts/')
            ->and(public_path(ltrim($url, '/')))->toBeFile();
    }
});
