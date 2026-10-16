<?php

// BRG-5 (brg-31) · spec docs/specs/brg-31.md §4 · tests 4 and 5
// Guard that keeps the site's tokens in sync with the reference implementation in prototype/.

function brandCss(string $path): string
{
    return (string) preg_replace('#/\*.*?\*/#s', '', (string) file_get_contents($path));
}

/** @return array<string, string> custom property => value, for every rule whose selector is exactly $selector */
function customProperties(string $css, string $selector): array
{
    preg_match_all('/([^{}]+)\{([^{}]*)\}/', $css, $rules, PREG_SET_ORDER);
    $props = [];

    foreach ($rules as [, $ruleSelector, $body]) {
        if (preg_replace('/\s+/', ' ', trim($ruleSelector)) !== $selector) {
            continue;
        }
        preg_match_all('/(--[a-z0-9-]+)\s*:\s*([^;]+);/', $body, $declarations, PREG_SET_ORDER);
        foreach ($declarations as [, $name, $value]) {
            $props[$name] = trim($value);
        }
    }

    return $props;
}

/** @return array<string, string> every --color-* declared in any @theme block */
function themeColors(string $css): array
{
    preg_match_all('/@theme[^{]*\{([^}]*)\}/', $css, $blocks);
    preg_match_all('/(--color-[a-z0-9-]+)\s*:\s*([^;]+);/', implode("\n", $blocks[1]), $declarations, PREG_SET_ORDER);
    $colors = [];

    foreach ($declarations as [, $name, $value]) {
        $colors[$name] = trim($value);
    }

    return $colors;
}

$site = dirname(__DIR__, 3).'/resources/css/app.css';
$prototype = dirname(__DIR__, 4).'/prototype/src/styles/app.css';

it('keeps the site palette identical to the prototype', function () use ($site, $prototype) {
    $expected = themeColors(brandCss($prototype));

    expect($expected)->toHaveKey('--color-rastro')
        ->and(themeColors(brandCss($site)))->toBe($expected);
});

it('keeps both mode roles identical to the prototype', function (string $selector) use ($site, $prototype) {
    $expected = customProperties(brandCss($prototype), $selector);

    expect($expected)->toHaveKey('--accent')
        ->and(customProperties(brandCss($site), $selector))->toBe($expected);
})->with([':root, .mode-documento', '.mode-cabina']);
