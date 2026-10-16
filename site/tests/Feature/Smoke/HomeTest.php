<?php

// BRG-5 (brg-31) · spec docs/specs/brg-31.md §4 · test 1

it('serves the placeholder home in Spanish', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="es"', false)
        ->assertSee('Bridge Traducciones')
        ->assertSee('Traducción certificada e interpretación simultánea, desde Quito.');
});
