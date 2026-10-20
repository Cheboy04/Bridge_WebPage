<?php

// BRG-47 (brg-37) · spec docs/specs/brg-37.md §4 · tests 1–7
// BRG-13 (brg-02) · spec docs/specs/brg-02.md §4 · test 15 (last case)
// The catalogue and Settings seeders never overwrite; demo content never reaches production.

use App\Enums\ServiceMode;
use App\Enums\UserRole;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

function serviceSlugs(Language $language): array
{
    return $language->services->map(fn (Service $service) => $service->getTranslation('slug', 'es'))->sort()->values()->all();
}

function seededCounts(): array
{
    return collect(['languages', 'services', 'language_service', 'settings', 'faqs', 'posts', 'clients', 'testimonials', 'pages', 'users'])
        ->mapWithKeys(fn (string $table) => [$table => DB::table($table)->count()])
        ->all();
}

it('seeds the example languages with their services', function () {
    $this->seed();

    $english = Language::where('code', 'en')->firstOrFail();
    $kichwa = Language::where('code', 'qu')->firstOrFail();

    expect(Language::count())->toBe(14)
        ->and($english->featured)->toBeTrue()
        ->and(serviceSlugs($english))->toBe(['certificada', 'legal', 'notariada'])
        ->and(serviceSlugs($kichwa))->toBe(['certificada']);
});

it('seeds the service catalogue by hub', function () {
    $this->seed();

    expect(Service::count())->toBe(7)
        ->and(Service::where('mode', ServiceMode::Documento)->count())->toBe(4)
        ->and(Service::where('mode', ServiceMode::Cabina)->count())->toBe(3)
        ->and(Service::where('slug->es', 'simultanea')->firstOrFail()->mode)->toBe(ServiceMode::Cabina);
});

it('seeds one empty settings row', function () {
    $this->seed();

    // Count before reading: Settings::current() would create the row itself.
    expect(DB::table('settings')->count())->toBe(1);

    $settings = Settings::firstOrFail();

    expect($settings)
        ->and($settings->contact_email)->toBeNull()
        ->and($settings->whatsapp_number)->toBeNull()
        ->and($settings->founding_year)->toBeNull();
});

it('keeps admin edits when seeding again', function () {
    $this->seed();
    $english = Language::where('code', 'en')->firstOrFail();
    $english->setTranslation('name', 'es', 'Inglés (editado)')->save();
    Service::where('slug->es', 'legal')->firstOrFail()->update(['published' => false]);

    $this->seed();

    expect($english->fresh()->getTranslation('name', 'es'))->toBe('Inglés (editado)')
        ->and(Service::where('slug->es', 'legal')->firstOrFail()->published)->toBeFalse()
        ->and(Language::count())->toBe(14);
});

it('can seed twice without duplicating anything', function () {
    $this->seed();
    $first = seededCounts();

    $this->seed();

    expect(seededCounts())->toBe($first);
});

it('seeds a browsable demo dataset outside production', function () {
    $this->seed();

    $certified = Service::where('slug->es', 'certificada')->firstOrFail();

    expect(Post::count())->toBeGreaterThan(0)
        ->and(Faq::whereNull('service_id')->count())->toBeGreaterThan(0)
        ->and($certified->faqs()->count())->toBeGreaterThan(0)
        ->and(Client::count())->toBeGreaterThan(0)
        ->and(Page::where('slug->es', 'privacidad')->exists())->toBeTrue()
        ->and(Page::where('slug->es', 'nosotros')->exists())->toBeTrue()
        ->and(User::where('email', 'test@example.com')->exists())->toBeTrue();
});

it('keeps demo content out of production', function () {
    app()->detectEnvironment(fn () => 'production');

    // Production asks for confirmation; --force is how a release would run it.
    $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

    expect(Post::count())->toBe(0)
        ->and(Client::count())->toBe(0)
        ->and(User::count())->toBe(0)
        ->and(Language::count())->toBe(14)
        ->and(Service::count())->toBe(7);
});

it('seeds an admin and an editor for demos', function () {
    $this->seed();

    expect(User::firstWhere('email', 'test@example.com')->role)->toBe(UserRole::Admin)
        ->and(User::firstWhere('email', 'editor@example.com')->role)->toBe(UserRole::Editor);
});
