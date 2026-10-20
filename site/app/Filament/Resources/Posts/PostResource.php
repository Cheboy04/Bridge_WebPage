<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Fields\SlugFields;
use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return __('admin.posts.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.posts.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...SlugFields::make('admin.posts.fields'),
                Textarea::make('excerpt')
                    ->label(__('admin.posts.fields.excerpt'))
                    ->maxLength(500)
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->label(__('admin.posts.fields.body'))
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('cover')
                    ->label(__('admin.posts.fields.cover'))
                    ->image()
                    ->disk('public')
                    ->directory('posts'),
                DateTimePicker::make('published_at')
                    ->label(__('admin.posts.fields.published_at'))
                    ->helperText(__('admin.posts.fields.published_at_help'))
                    ->seconds(false),
                TextInput::make('seo_title')
                    ->label(__('admin.posts.fields.seo_title'))
                    ->maxLength(255),
                Textarea::make('seo_description')
                    ->label(__('admin.posts.fields.seo_description'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('admin.posts.fields.title'))
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('admin.posts.fields.status'))
                    ->state(fn (Post $post): string => match (true) {
                        $post->published_at === null => 'draft',
                        $post->published_at->isFuture() => 'scheduled',
                        default => 'published',
                    })
                    ->formatStateUsing(fn (string $state): string => __("admin.posts.status.{$state}"))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'scheduled' => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('published_at')
                    ->label(__('admin.posts.fields.published_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
