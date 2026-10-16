<?php

// BRG-5 (brg-31) · spec docs/specs/brg-31.md §4 · test 7
// The repo is public (ADR D2.2): the env example must never carry a real secret.

it('ships an env example without real values', function () {
    $env = [];

    foreach (file(dirname(__DIR__, 3).'/.env.example', FILE_IGNORE_NEW_LINES) ?: [] as $line) {
        if (preg_match('/^([A-Z0-9_]+)=(.*)$/', $line, $match)) {
            $env[$match[1]] = $match[2];
        }
    }

    expect($env)->toHaveKey('APP_LOCALE', 'es')
        ->toHaveKey('APP_DEBUG', 'false');

    foreach ($env as $key => $value) {
        if (preg_match('/_(PASSWORD|SECRET|KEY)$/', $key)) {
            expect($value)->toBe('', "{$key} must be empty in .env.example");
        }
    }
});
