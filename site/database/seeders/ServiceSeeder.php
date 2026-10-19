<?php

namespace Database\Seeders;

use App\Enums\ServiceMode;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * The prototype's example catalogue (placeholder register #15). Creates what's
 * missing and never overwrites, so Bridge's edits in the admin survive a rerun.
 */
class ServiceSeeder extends Seeder
{
    /** @var list<array{string, string, ServiceMode}> slug, title, mode */
    private const SERVICES = [
        ['certificada', 'Traducción certificada', ServiceMode::Documento],
        ['legal', 'Traducción legal', ServiceMode::Documento],
        ['notariada', 'Traducción notariada', ServiceMode::Documento],
        ['escrita', 'Traducción escrita', ServiceMode::Documento],
        ['simultanea', 'Interpretación simultánea', ServiceMode::Cabina],
        ['consecutiva', 'Interpretación consecutiva', ServiceMode::Cabina],
        ['equipos-y-cabinas', 'Equipos y cabinas', ServiceMode::Cabina],
    ];

    public function run(): void
    {
        foreach (self::SERVICES as $sort => [$slug, $title, $mode]) {
            if (Service::where('slug->es', $slug)->exists()) {
                continue;
            }

            Service::create([
                'title' => ['es' => $title],
                'slug' => ['es' => $slug],
                'mode' => $mode,
                'sort' => $sort,
                'published' => true,
            ]);
        }
    }
}
