<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\Clients\Pages\CreateClient;
use App\Filament\Resources\Clients\Pages\EditClient;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Models\Client;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('admin.clients.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.clients.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('admin.clients.fields.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('sector')
                    ->label(__('admin.clients.fields.sector'))
                    ->maxLength(255),
                TextInput::make('url')
                    ->label(__('admin.clients.fields.url'))
                    ->url()
                    ->maxLength(255),
                FileUpload::make('logo')
                    ->label(__('admin.clients.fields.logo'))
                    ->image()
                    ->disk('public')
                    ->directory('clients'),
                Toggle::make('logo_permission')
                    ->label(__('admin.clients.fields.logo_permission'))
                    ->helperText(__('admin.clients.fields.logo_permission_help'))
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('admin.clients.fields.logo'))
                    ->disk('public'),
                TextColumn::make('name')
                    ->label(__('admin.clients.fields.name'))
                    ->searchable(),
                TextColumn::make('sector')
                    ->label(__('admin.clients.fields.sector')),
                IconColumn::make('logo_permission')
                    ->label(__('admin.clients.fields.logo_permission'))
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
            'index' => ListClients::route('/'),
            'create' => CreateClient::route('/create'),
            'edit' => EditClient::route('/{record}/edit'),
        ];
    }
}
