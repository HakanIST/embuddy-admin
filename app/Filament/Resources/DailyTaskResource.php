<?php
namespace App\Filament\Resources;
use App\Filament\Resources\DailyTaskResource\Pages;
use App\Models\DailyTask;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DailyTaskResource extends Resource {
    protected static ?string $model = DailyTask::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string | \UnitEnum | null $navigationGroup = 'Gamification';
    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Schemas\Components\TextInput::make('title')->required()->maxLength(255),
            Schemas\Components\TextInput::make('xpReward')->numeric()->default(10)->label('XP Reward'),
            Schemas\Components\Select::make('taskType')->options([
                'profile' => 'Profile', 'mood' => 'Mood', 'guide' => 'Guide',
                'word' => 'Word', 'campus' => 'Campus',
            ])->required()->label('Task Type'),
            Schemas\Components\Toggle::make('isRecurring')->default(true)->label('Recurring Daily'),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('taskType')->badge()->label('Type'),
            Tables\Columns\TextColumn::make('xpReward')->badge()->color('warning')->suffix(' XP'),
            Tables\Columns\IconColumn::make('isRecurring')->boolean()->label('Recurring'),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListDailyTasks::route('/'),
            'create' => Pages\CreateDailyTask::route('/create'),
            'edit' => Pages\EditDailyTask::route('/{record}/edit'),
        ];
    }
}
