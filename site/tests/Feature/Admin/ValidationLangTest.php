<?php

// BRG-14 (brg-03) · spec docs/specs/brg-03.md §4 · test 11

it('shows validation messages in Spanish', function (string $key) {
    $message = __("validation.$key", ['attribute' => 'slug', 'max' => 10]);

    expect($message)
        ->not->toBe("validation.$key")
        ->not->toBe(trans("validation.$key", ['attribute' => 'slug', 'max' => 10], 'en'));
})->with(['required', 'unique', 'regex', 'max.string']);
