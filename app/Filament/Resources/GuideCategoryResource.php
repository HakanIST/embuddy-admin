<?php
namespace App\Filament\Resources;
use App\Filament\Resources\GuideCategoryResource\Pages;
use App\Models\GuideCategory;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuideCategoryResource extends Resource {
    protected static ?string $model = GuideCategory::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    protected static string | \UnitEnum | null $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(100),
            Forms\Components\TextInput::make('icon')->maxLength(100)->helperText('SF Symbol name'),
            Forms\Components\ColorPicker::make('color'),
            Forms\Components\TextInput::make('articleCount')->numeric()->default(0)->label('Article Count'),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\ColorColumn::make('color'),
            Tables\Columns\TextColumn::make('articleCount')->sortable()->badge()->color('info'),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListGuideCategories::route('/'),
            'create' => Pages\CreateGuideCategory::route('/create'),
            'edit' => Pages\EditGuideCategory::route('/{record}/edit'),
        ];
    }
}
