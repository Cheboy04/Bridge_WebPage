<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * The prototype's example language list, prototype/src/assets/data/languages.json
 * (placeholder register #16). Creates what's missing and never overwrites; links
 * are attached only when the language is created.
 */
class LanguageSeeder extends Seeder
{
    /** @var list<array{string, string, bool, list<string>}> code, name, featured, service slugs */
    private const LANGUAGES = [
        ['es', 'Español', true, ['certificada', 'legal', 'notariada']],
        ['en', 'Inglés', true, ['certificada', 'legal', 'notariada']],
        ['fr', 'Francés', true, ['certificada', 'legal', 'notariada']],
        ['pt', 'Portugués', true, ['certificada', 'legal', 'notariada']],
        ['de', 'Alemán', true, ['certificada', 'legal', 'notariada']],
        ['it', 'Italiano', true, ['certificada', 'legal', 'notariada']],
        ['zh', 'Chino', false, ['certificada', 'legal']],
        ['ja', 'Japonés', false, ['certificada', 'legal']],
        ['ru', 'Ruso', false, ['certificada', 'legal']],
        ['ar', 'Árabe', false, ['certificada']],
        ['ko', 'Coreano', false, ['certificada']],
        ['nl', 'Neerlandés', false, ['certificada', 'legal']],
        ['el', 'Griego', false, ['certificada']],
        ['qu', 'Kichwa', false, ['certificada']],
    ];

    public function run(): void
    {
        foreach (self::LANGUAGES as $sort => [$code, $name, $featured, $slugs]) {
            $language = Language::firstOrCreate(
                ['code' => $code],
                ['name' => ['es' => $name], 'featured' => $featured, 'sort' => $sort, 'published' => true],
            );

            if ($language->wasRecentlyCreated) {
                $language->services()->attach(
                    Service::query()->get()->filter(
                        fn (Service $service) => in_array($service->getTranslation('slug', 'es'), $slugs, true)
                    )
                );
            }
        }
    }
}
