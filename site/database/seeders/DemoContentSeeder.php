<?php

namespace Database\Seeders;

use App\Enums\ServiceMode;
use App\Enums\UserRole;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Invented content so the site and admin are browsable (ADR D2.2). Never in
 * production, and only once: it skips when posts already exist.
 */
class DemoContentSeeder extends Seeder
{
    private const PLACEHOLDER = '[Texto por confirmar con Bridge]';

    public function run(): void
    {
        if (app()->isProduction() || Post::exists()) {
            return;
        }

        // `role` is not fillable (brg-35 §3.5), so the admin role is forced.
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            User::factory()->raw(['name' => 'Test User', 'email' => 'test@example.com']),
        )->forceFill(['role' => UserRole::Admin])->save();
        User::firstOrCreate(
            ['email' => 'editor@example.com'],
            User::factory()->raw(['name' => 'Editor Demo', 'email' => 'editor@example.com']),
        );

        Faq::factory()->count(5)->create();
        Service::where('mode', ServiceMode::Documento)->each(
            fn (Service $service) => Faq::factory()->count(2)->forService($service)->create()
        );

        Post::factory()->count(3)->create();
        Client::factory()->count(6)->create();
        Testimonial::factory()->count(2)->create();

        foreach (['privacidad' => 'Política de privacidad', 'nosotros' => 'Nosotros'] as $slug => $title) {
            Page::factory()->create([
                'title' => ['es' => $title],
                'slug' => ['es' => $slug],
                'body' => ['es' => '<p>'.self::PLACEHOLDER.'</p>'],
            ]);
        }
    }
}
