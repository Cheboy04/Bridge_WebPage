<?php

namespace App\Filament\Resources\Services;

use App\Enums\ServiceMode;
use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static ?string $recordTitleAttribute = 'title';

    /** Lowercase kebab: URL slugs and sprite ids (spec brg-03 §3.3). */
    private const KEBAB = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';

    public static function getModelLabel(): string
    {
        return __('admin.services.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.services.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('admin.services.fields.title'))
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, string $operation): void {
                        if ($operation === 'create') {
                            $set('slug', Str::slug((string) $state));
                        }
                    }),
                TextInput::make('slug')
                    ->label(__('admin.services.fields.slug'))
                    ->required()
                    ->maxLength(255)
                    ->regex(self::KEBAB)
                    // ERD I3: unique across all services, like the functional index.
                    ->unique(column: 'slug->es', ignoreRecord: true),
                Select::make('mode')
                    ->label(__('admin.services.fields.mode'))
                    ->options(ServiceMode::class)
                    ->required(),
                Textarea::make('summary')
                    ->label(__('admin.services.fields.summary'))
                    ->maxLength(500),
                RichEditor::make('body')
                    ->label(__('admin.services.fields.body'))
                    ->columnSpanFull(),
                TextInput::make('icon')
                    ->label(__('admin.services.fields.icon'))
                    ->helperText(__('admin.services.fields.icon_help'))
                    ->maxLength(255)
                    ->regex(self::KEBAB),
                FileUpload::make('image')
                    ->label(__('admin.services.fields.image'))
                    ->image()
                    ->disk('public')
                    ->directory('services'),
                TextInput::make('turnaround')
                    ->label(__('admin.services.fields.turnaround'))
                    ->maxLength(255),
                Toggle::make('featured')
                    ->label(__('admin.services.fields.featured')),
                Toggle::make('published')
                    ->label(__('admin.services.fields.published'))
                    ->default(false),
                TextInput::make('seo_title')
                    ->label(__('admin.services.fields.seo_title'))
                    ->maxLength(255),
                Textarea::make('seo_description')
                    ->label(__('admin.services.fields.seo_description'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('admin.services.fields.title'))
                    ->searchable(),
                TextColumn::make('mode')
                    ->label(__('admin.services.fields.mode'))
                    ->badge(),
                IconColumn::make('published')
                    ->label(__('admin.services.fields.published'))
                    ->boolean(),
                IconColumn::make('featured')
                    ->label(__('admin.services.fields.featured'))
                    ->boolean(),
            ])
            ->defaultSort('sort')
            ->reorderable('sort')
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
