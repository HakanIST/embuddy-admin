<?php
namespace App\Filament\Resources;

use App\Filament\Resources\GuideResource\Pages;
use App\Models\Guide;
use App\Models\GuideCategory;
use Filament\Forms;
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
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\Select::make('categoryId')
                    ->label('Category')
                    ->options(GuideCategory::pluck('name', 'id'))
                    ->required(),
                Forms\Components\Textarea::make('summary')->rows(3),
                Forms\Components\MarkdownEditor::make('content'),
                Forms\Components\TextInput::make('readTimeMinutes')->numeric()->default(5)->label('Read Time (min)'),
                Forms\Components\TextInput::make('icon')->maxLength(100),
                Forms\Components\Toggle::make('isMandatory')->label('Mandatory'),
            ])->columns(2),
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
