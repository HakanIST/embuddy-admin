<?php
namespace App\Filament\Resources;
use App\Filament\Resources\WordOfDayResource\Pages;
use App\Models\WordOfDay;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WordOfDayResource extends Resource {
    protected static ?string $model = WordOfDay::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-language';
    protected static string | \UnitEnum | null $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Word of the Day';

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Forms\Components\TextInput::make('turkishWord')->required()->maxLength(255)->label('Turkish Word'),
            Forms\Components\TextInput::make('pronunciation')->maxLength(255),
            Forms\Components\TextInput::make('englishTranslation')->required()->maxLength(255)->label('English'),
            Forms\Components\Textarea::make('definition')->rows(2),
            Forms\Components\DatePicker::make('date')->required()->unique(ignoreRecord: true)->native(false),
            Forms\Components\TextInput::make('xpReward')->numeric()->default(25)->label('XP Reward'),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('date')->sortable(),
            Tables\Columns\TextColumn::make('turkishWord')->searchable()->sortable()->label('Turkish'),
            Tables\Columns\TextColumn::make('pronunciation'),
            Tables\Columns\TextColumn::make('englishTranslation')->label('English'),
            Tables\Columns\TextColumn::make('xpReward')->badge()->color('success')->suffix(' XP'),
        ])
        ->defaultSort('date', 'desc')
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListWordOfDays::route('/'),
            'create' => Pages\CreateWordOfDay::route('/create'),
            'edit' => Pages\EditWordOfDay::route('/{record}/edit'),
        ];
    }
}
