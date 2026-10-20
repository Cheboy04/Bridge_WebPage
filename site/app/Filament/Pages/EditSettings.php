<?php

namespace App\Filament\Pages;

use App\Models\Settings;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * The single Settings row, admin only (spec brg-09, ADR D8.1).
 *
 * @property-read Schema $form
 */
class EditSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $slug = 'settings';

    /** International format: +, country code, digits and single spaces. */
    private const PHONE = '/^\+[1-9]\d{0,2}( ?\d){6,14}$/';

    /** What wa.me accepts: digits only, country code first. */
    private const WHATSAPP = '/^[1-9]\d{7,14}$/';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return $user instanceof User && $user->can('viewAny', Settings::class);
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.settings.title');
    }

    public function getTitle(): string
    {
        return __('admin.settings.title');
    }

    public function mount(): void
    {
        $settings = Settings::current();
        $data = $settings->attributesToArray();

        // Spatie casts translatable columns to arrays; fill the `es` value (brg-03 §3.3).
        foreach ($settings->getTranslatableAttributes() as $attribute) {
            $data[$attribute] = $settings->getAttribute($attribute);
        }

        $this->form->fill($data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make(__('admin.settings.sections.contact'))
                    ->columns(2)
                    ->components([
                        TextInput::make('phone_landline')
                            ->label(__('admin.settings.fields.phone_landline'))
                            ->tel()
                            ->regex(self::PHONE)
                            ->helperText(__('admin.settings.fields.phone_help')),
                        TextInput::make('phone_mobile')
                            ->label(__('admin.settings.fields.phone_mobile'))
                            ->tel()
                            ->regex(self::PHONE)
                            ->helperText(__('admin.settings.fields.phone_help')),
                        TextInput::make('contact_email')
                            ->label(__('admin.settings.fields.contact_email'))
                            ->email()
                            ->maxLength(255),
                        TextInput::make('notification_email')
                            ->label(__('admin.settings.fields.notification_email'))
                            ->helperText(__('admin.settings.fields.notification_email_help'))
                            ->email()
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label(__('admin.settings.fields.address'))
                            ->maxLength(255),
                        TextInput::make('map_url')
                            ->label(__('admin.settings.fields.map_url'))
                            ->url()
                            ->maxLength(255),
                        TextInput::make('office_hours')
                            ->label(__('admin.settings.fields.office_hours'))
                            ->maxLength(255),
                    ]),
                Section::make(__('admin.settings.sections.whatsapp'))
                    ->components([
                        TextInput::make('whatsapp_number')
                            ->label(__('admin.settings.fields.whatsapp_number'))
                            ->regex(self::WHATSAPP)
                            ->helperText(__('admin.settings.fields.whatsapp_help')),
                        Textarea::make('whatsapp_default_message')
                            ->label(__('admin.settings.fields.whatsapp_default_message'))
                            ->maxLength(500),
                    ]),
                Section::make(__('admin.settings.sections.presence'))
                    ->components([
                        Repeater::make('socials')
                            ->label(__('admin.settings.fields.socials'))
                            ->columns(2)
                            ->defaultItems(0)
                            ->components([
                                TextInput::make('network')
                                    ->label(__('admin.settings.fields.network'))
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('url')
                                    ->label(__('admin.settings.fields.url'))
                                    ->required()
                                    ->url()
                                    ->maxLength(255),
                            ]),
                        TextInput::make('founding_year')
                            ->label(__('admin.settings.fields.founding_year'))
                            ->integer()
                            ->minValue(1900)
                            ->maxValue((int) date('Y')),
                        TextInput::make('legal_name')
                            ->label(__('admin.settings.fields.legal_name'))
                            ->maxLength(255),
                    ]),
                Section::make(__('admin.settings.sections.credentials'))
                    ->components([
                        Textarea::make('ata_text')
                            ->label(__('admin.settings.fields.ata_text'))
                            ->maxLength(500),
                        Repeater::make('stats')
                            ->label(__('admin.settings.fields.stats'))
                            ->helperText(__('admin.settings.fields.stats_help'))
                            ->columns(2)
                            ->defaultItems(0)
                            ->components([
                                TextInput::make('value')
                                    ->label(__('admin.settings.fields.stat_value'))
                                    ->required()
                                    ->maxLength(20),
                                TextInput::make('label')
                                    ->label(__('admin.settings.fields.stat_label'))
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('source')
                                    ->label(__('admin.settings.fields.stat_source'))
                                    ->required()
                                    ->maxLength(255),
                                DatePicker::make('verified_on')
                                    ->label(__('admin.settings.fields.stat_verified_on'))
                                    ->required(),
                            ]),
                    ]),
                Section::make(__('admin.settings.sections.hero'))
                    ->components([
                        TextInput::make('hero_hook')
                            ->label(__('admin.settings.fields.hero_hook'))
                            ->helperText(__('admin.settings.fields.hero_hook_help'))
                            ->maxLength(255),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label(__('admin.settings.save'))
                            ->submit('save'),
                    ]),
                ]),
        ]);
    }

    public function save(): void
    {
        $settings = Settings::current();
        $this->authorize('update', $settings);

        $settings->fill($this->form->getState())->save();

        Notification::make()->success()->title(__('admin.settings.saved'))->send();
    }
}
