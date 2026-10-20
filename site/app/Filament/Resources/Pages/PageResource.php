<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Fields\SlugFields;
use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return __('admin.pages.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.pages.plural');
    }

    public static function form(Schema $schema): Schema
    {
        [$title, $slug] = SlugFields::make('admin.pages.fields');

        return $schema
            ->components([
                $title,
                // Routes look pages up by slug (ERD §3.8): renaming one takes it off the site.
                $slug->disabledOn('edit')->helperText(__('admin.pages.fields.slug_help')),
                RichEditor::make('body')
                    ->label(__('admin.pages.fields.body'))
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('seo_title')
                    ->label(__('admin.pages.fields.seo_title'))
                    ->maxLength(255),
                Textarea::make('seo_description')
                    ->label(__('admin.pages.fields.seo_description'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('admin.pages.fields.title'))
                    ->searchable(),
                TextColumn::make('slug')
                    ->label(__('admin.pages.fields.slug')),
                TextColumn::make('updated_at')
                    ->label(__('admin.pages.fields.updated_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
