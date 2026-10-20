<?php

// BRG-20 (brg-09) · spec docs/specs/brg-09.md §4 · tests 1–8

use App\Filament\Pages\EditSettings;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

it('opens the settings page only for admins', function (string $role, int $status) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();

    $this->actingAs($user)->get('/admin/settings')->assertStatus($status);
})->with([
    'admin' => ['admin', 200],
    'editor' => ['editor', 403],
]);

it('forbids an editor from saving', function () {
    $this->actingAs(User::factory()->create());
    Settings::current();

    Livewire::test(EditSettings::class)->assertForbidden();

    expect(Settings::current()->contact_email)->toBeNull();
});

it('saves the settings', function () {
    Livewire::test(EditSettings::class)
        ->fillForm([
            'phone_landline' => '+593 2 000 0000',
            'whatsapp_number' => '593990000000',
            'contact_email' => 'contacto@bridge.example.test',
            'office_hours' => 'Lunes a viernes, 9:00–18:00',
            'socials' => [['network' => 'LinkedIn', 'url' => 'https://example.test/bridge']],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $settings = Settings::current();

    expect(Settings::count())->toBe(1)
        ->and($settings->phone_landline)->toBe('+593 2 000 0000')
        ->and($settings->whatsapp_number)->toBe('593990000000')
        ->and($settings->contact_email)->toBe('contacto@bridge.example.test')
        ->and($settings->getTranslations('office_hours'))->toBe(['es' => 'Lunes a viernes, 9:00–18:00'])
        ->and($settings->socials)->toBe([['network' => 'LinkedIn', 'url' => 'https://example.test/bridge']]);
});

it('loads the saved values in Spanish', function () {
    Settings::current()->fill(['hero_hook' => 'Del original a la firma.'])->save();

    Livewire::test(EditSettings::class)
        ->assertSchemaStateSet(['hero_hook' => 'Del original a la firma.']);
});

it('rejects a phone that is not international', function (string $phone) {
    Livewire::test(EditSettings::class)
        ->fillForm(['phone_landline' => $phone])
        ->call('save')
        ->assertHasFormErrors(['phone_landline' => 'regex']);
})->with(['022000000', '+593 2 abc 0000', '+0 2 000 0000']);

it('rejects a WhatsApp number that wa.me cannot use', function (string $number) {
    Livewire::test(EditSettings::class)
        ->fillForm(['whatsapp_number' => $number])
        ->call('save')
        ->assertHasFormErrors(['whatsapp_number' => 'regex']);
})->with(['+593990000000', '099 000 0000']);

it('keeps a documented stat with its source and date', function () {
    $stat = ['value' => '500+', 'label' => 'clientes atendidos', 'source' => 'Registro interno', 'verified_on' => '2026-10-01'];

    Livewire::test(EditSettings::class)
        ->fillForm(['stats' => [$stat]])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Settings::current()->getTranslation('stats', 'es'))->toBe([$stat]);
});

it('shows a saved change on the next read', function () {
    Settings::current();

    Livewire::test(EditSettings::class)
        ->fillForm(['contact_email' => 'nuevo@bridge.example.test'])
        ->call('save');

    expect(Settings::current()->contact_email)->toBe('nuevo@bridge.example.test');
});
