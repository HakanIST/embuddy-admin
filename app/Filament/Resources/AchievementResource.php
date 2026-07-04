<?php
namespace App\Filament\Resources;
use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AchievementResource extends Resource {
    protected static ?string $model = Achievement::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-trophy';
    protected static string | \UnitEnum | null $navigationGroup = 'Gamification';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\Textarea::make('description')->rows(2),
            Forms\Components\TextInput::make('icon')->maxLength(100)->helperText('SF Symbol name'),
            Forms\Components\TextInput::make('xpReward')->numeric()->default(0)->label('XP Reward'),
            Forms\Components\Select::make('conditionType')->options([
                'streak' => 'Streak', 'checkin' => 'Check-in', 'guide' => 'Guide Read',
                'profile' => 'Profile', 'campus' => 'Campus',
            ])->label('Condition Type'),
            Forms\Components\TextInput::make('conditionValue')->numeric()->default(1)->label('Condition Value'),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('xpReward')->badge()->color('warning')->suffix(' XP'),
            Tables\Columns\TextColumn::make('conditionType')->badge(),
            Tables\Columns\TextColumn::make('conditionValue'),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
