<?php

namespace App\Filament\Resources\Faqs;

use App\Filament\Resources\Faqs\Pages\CreateFaq;
use App\Filament\Resources\Faqs\Pages\EditFaq;
use App\Filament\Resources\Faqs\Pages\ListFaqs;
use App\Models\Faq;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    public static function getModelLabel(): string
    {
        return __('admin.faqs.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.faqs.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label(__('admin.faqs.fields.question'))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                RichEditor::make('answer')
                    ->label(__('admin.faqs.fields.answer'))
                    ->required()
                    ->columnSpanFull(),
                Select::make('service_id')
                    ->label(__('admin.faqs.fields.service'))
                    ->placeholder(__('admin.faqs.fields.service_placeholder'))
                    ->relationship('service', 'title')
                    ->getOptionLabelFromRecordUsing(fn (Service $service): string => $service->title),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->columns([
                TextColumn::make('question')
                    ->label(__('admin.faqs.fields.question'))
                    ->limit(80)
                    ->searchable(),
                TextColumn::make('service.title')
                    ->label(__('admin.faqs.fields.service'))
                    ->placeholder(__('admin.faqs.general')),
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
