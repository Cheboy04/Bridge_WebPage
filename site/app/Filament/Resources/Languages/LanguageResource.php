<?php

namespace App\Filament\Resources\Languages;

use App\Filament\Resources\Languages\Pages\CreateLanguage;
use App\Filament\Resources\Languages\Pages\EditLanguage;
use App\Filament\Resources\Languages\Pages\ListLanguages;
use App\Models\Language;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('admin.languages.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.languages.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('admin.languages.fields.code'))
                    ->helperText(__('admin.languages.fields.code_help'))
                    ->required()
                    ->maxLength(10)
                    ->regex('/^[a-z]{2,3}(-[A-Z]{2})?$/')
                    ->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->label(__('admin.languages.fields.name'))
                    ->required()
                    ->maxLength(255),
                CheckboxList::make('services')
                    ->label(__('admin.languages.fields.services'))
                    ->relationship('services', 'title', fn (Builder $query) => $query->orderBy('sort')->orderBy('id'))
                    ->getOptionLabelFromRecordUsing(fn (Service $service): string => $service->title),
                Toggle::make('featured')
                    ->label(__('admin.languages.fields.featured')),
                Toggle::make('published')
                    ->label(__('admin.languages.fields.published'))
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('code')
                    ->label(__('admin.languages.fields.code'))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('admin.languages.fields.name')),
                IconColumn::make('featured')
                    ->label(__('admin.languages.fields.featured'))
                    ->boolean(),
                IconColumn::make('published')
                    ->label(__('admin.languages.fields.published'))
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
            'index' => ListLanguages::route('/'),
            'create' => CreateLanguage::route('/create'),
            'edit' => EditLanguage::route('/{record}/edit'),
        ];
    }
}
