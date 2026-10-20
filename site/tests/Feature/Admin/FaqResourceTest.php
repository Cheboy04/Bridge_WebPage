<?php

// BRG-16 (brg-05) · spec docs/specs/brg-05.md §4 · tests 1–7

use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Faqs\Pages\EditFaq;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Models\Faq;
use App\Models\Service;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('opens the faq pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/faqs',
        'create' => '/admin/faqs/create',
        'edit' => '/admin/faqs/'.Faq::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('lets an editor create a global faq', function () {
    Service::factory()->create();

    Livewire::test(CreateFaq::class)
        ->fillForm(['question' => '¿Cuánto tarda?', 'answer' => '<p>Depende del documento.</p>'])
        ->call('create')
        ->assertHasNoFormErrors();

    $faq = Faq::sole();

    expect($faq->getTranslations('question'))->toBe(['es' => '¿Cuánto tarda?'])
        ->and($faq->service_id)->toBeNull();
});

it('lets an editor attach a faq to a service', function () {
    $service = Service::factory()->create();

    Livewire::test(CreateFaq::class)
        ->fillForm(['question' => '¿Es válida?', 'answer' => '<p>Sí.</p>', 'service_id' => $service->id])
        ->call('create')
        ->assertHasNoFormErrors();

    expect($service->faqs()->pluck('id')->all())->toBe([Faq::sole()->id]);
});

it('requires a question and an answer', function () {
    Livewire::test(CreateFaq::class)
        ->fillForm(['question' => '', 'answer' => ''])
        ->call('create')
        ->assertHasFormErrors(['question' => 'required', 'answer' => 'required']);
});

it('loads the Spanish question into the edit form', function () {
    $faq = Faq::factory()->create(['question' => ['es' => '¿Atienden sábados?']]);

    Livewire::test(EditFaq::class, ['record' => $faq->getRouteKey()])
        ->assertSchemaStateSet(['question' => '¿Atienden sábados?']);
});

it('reorders faqs by drag', function () {
    [$a, $b, $c] = Faq::factory()->count(3)->sequence(['sort' => 1], ['sort' => 2], ['sort' => 3])->create();

    Livewire::test(ListFaqs::class)->call('reorderTable', [$c->id, $a->id, $b->id]);

    expect(Faq::orderBy('sort')->pluck('id')->all())->toBe([$c->id, $a->id, $b->id]);
});

it('lets an editor delete a faq', function () {
    $faq = Faq::factory()->create();

    Livewire::test(EditFaq::class, ['record' => $faq->getRouteKey()])
        ->callAction(DeleteAction::class);

    expect(Faq::count())->toBe(0);
});
