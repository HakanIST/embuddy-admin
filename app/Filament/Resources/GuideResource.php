<?php
namespace App\Filament\Resources;

use App\Filament\Resources\GuideResource\Pages;
use App\Models\Guide;
use App\Models\GuideCategory;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuideResource extends Resource
{
    protected static ?string $model = Guide::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-book-open';
    protected static string | \UnitEnum | null $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Guide Info')->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255)->columnSpanFull(),
                Forms\Components\Select::make('categoryId')
                    ->label('Category')
                    ->options(GuideCategory::pluck('name', 'id'))
                    ->required(),
                Forms\Components\Textarea::make('summary')->rows(2),
                Forms\Components\TextInput::make('readTimeMinutes')->numeric()->default(5)->label('Read Time (min)'),
                Forms\Components\TextInput::make('icon')->maxLength(100)->placeholder('SF Symbol name'),
                Forms\Components\Toggle::make('isMandatory')->label('Mandatory'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('Content Sections')->schema([
                Builder::make('content')
                    ->label('')
                    ->blocks([
                        Block::make('heading')
                            ->label('Heading')
                            ->icon('heroicon-o-hashtag')
                            ->schema([
                                Forms\Components\TextInput::make('text')->required()->label('Heading Text'),
                                Forms\Components\Select::make('level')
                                    ->options([1 => 'H1 — Title', 2 => 'H2 — Section', 3 => 'H3 — Subsection'])
                                    ->default(2)
                                    ->required(),
                            ])->columns(2),

                        Block::make('paragraph')
                            ->label('Paragraph')
                            ->icon('heroicon-o-bars-3-bottom-left')
                            ->schema([
                                Forms\Components\Textarea::make('text')->required()->rows(3)->label('Text'),
                            ]),

                        Block::make('list')
                            ->label('List')
                            ->icon('heroicon-o-list-bullet')
                            ->schema([
                                Forms\Components\Select::make('style')
                                    ->options(['unordered' => 'Bullet List', 'ordered' => 'Numbered List'])
                                    ->default('unordered'),
                                Forms\Components\Repeater::make('items')
                                    ->simple(Forms\Components\TextInput::make('item')->required())
                                    ->label('Items')
                                    ->minItems(1)
                                    ->defaultItems(2),
                            ]),

                        Block::make('callout')
                            ->label('Callout')
                            ->icon('heroicon-o-exclamation-circle')
                            ->schema([
                                Forms\Components\Select::make('style')
                                    ->options(['info' => '💙 Info', 'tip' => '💚 Tip', 'warning' => '⚠️ Warning'])
                                    ->default('info')
                                    ->required(),
                                Forms\Components\Textarea::make('text')->required()->rows(2)->label('Message'),
                            ]),

                        Block::make('table')
                            ->label('Table')
                            ->icon('heroicon-o-table-cells')
                            ->schema([
                                Forms\Components\TagsInput::make('headers')
                                    ->label('Column Headers')
                                    ->placeholder('Add a column header'),
                                Forms\Components\Repeater::make('rows')
                                    ->label('Rows')
                                    ->simple(
                                        Forms\Components\TagsInput::make('row')
                                            ->label('Cell values')
                                            ->placeholder('Add cell value')
                                    )
                                    ->minItems(1)
                                    ->defaultItems(2),
                            ]),

                        Block::make('contact')
                            ->label('Contact')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('label')->required()->placeholder('e.g. Emergency'),
                                Forms\Components\TextInput::make('phone')->required()->placeholder('+90...')->tel(),
                            ])->columns(2),

                        Block::make('link')
                            ->label('Link')
                            ->icon('heroicon-o-link')
                            ->schema([
                                Forms\Components\TextInput::make('text')->required()->placeholder('Link text'),
                                Forms\Components\TextInput::make('url')->required()->url()->placeholder('https://...'),
                            ])->columns(2),

                        Block::make('steps')
                            ->label('Steps')
                            ->icon('heroicon-o-numbered-list')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')->required(),
                                        Forms\Components\Textarea::make('description')->required()->rows(2),
                                    ])
                                    ->label('Steps')
                                    ->minItems(1)
                                    ->defaultItems(2),
                            ]),
                    ])
                    ->collapsible()
                    ->blockNumbers(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('category.name')->sortable()->badge()->color('info'),
                Tables\Columns\TextColumn::make('readTimeMinutes')->suffix(' min')->label('Read'),
                Tables\Columns\IconColumn::make('isMandatory')->boolean()->label('Required'),
                Tables\Columns\TextColumn::make('createdAt')->dateTime()->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('categoryId')
                    ->label('Category')
                    ->options(GuideCategory::pluck('name', 'id')),
            ])
            ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
            ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuides::route('/'),
            'create' => Pages\CreateGuide::route('/create'),
            'edit' => Pages\EditGuide::route('/{record}/edit'),
        ];
    }
}
