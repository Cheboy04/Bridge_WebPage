<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'person';

    public static function getModelLabel(): string
    {
        return __('admin.testimonials.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.testimonials.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('quote')
                    ->label(__('admin.testimonials.fields.quote'))
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull(),
                TextInput::make('person')
                    ->label(__('admin.testimonials.fields.person'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('role')
                    ->label(__('admin.testimonials.fields.role'))
                    ->maxLength(255),
                Select::make('client_id')
                    ->label(__('admin.testimonials.fields.client'))
                    ->relationship('client', 'name'),
                TextInput::make('company')
                    ->label(__('admin.testimonials.fields.company'))
                    ->helperText(__('admin.testimonials.fields.company_help'))
                    ->maxLength(255),
                Toggle::make('published')
                    ->label(__('admin.testimonials.fields.published'))
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('person')
            ->columns([
                TextColumn::make('person')
                    ->label(__('admin.testimonials.fields.person'))
                    ->searchable(),
                TextColumn::make('client.name')
                    ->label(__('admin.testimonials.fields.client')),
                TextColumn::make('company')
                    ->label(__('admin.testimonials.fields.company')),
                IconColumn::make('published')
                    ->label(__('admin.testimonials.fields.published'))
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
