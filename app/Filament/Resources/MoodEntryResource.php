<?php
namespace App\Filament\Resources;
use App\Filament\Resources\MoodEntryResource\Pages;
use App\Models\MoodEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MoodEntryResource extends Resource {
    protected static ?string $model = MoodEntry::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-heart';
    protected static string | \UnitEnum | null $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Mood Entries';

    public static function canCreate(): bool { return false; }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('user.fullName')->label('Student')->searchable(),
            Tables\Columns\TextColumn::make('mood')->badge()->color(fn ($state) => match($state) {
                'great' => 'success', 'good' => 'info', 'okay' => 'warning',
                'down' => 'danger', 'stressed' => 'danger', default => 'gray'
            }),
            Tables\Columns\TextColumn::make('note')->limit(40),
            Tables\Columns\TextColumn::make('createdAt')->dateTime()->sortable(),
        ])
        ->defaultSort('createdAt', 'desc')
        ->filters([
            \Filament\Tables\Filters\SelectFilter::make('mood')->options([
                'great' => '😄 Great', 'good' => '🙂 Good', 'okay' => '😐 Okay',
                'down' => '😔 Down', 'stressed' => '😰 Stressed',
            ]),
        ]);
    }

    public static function getPages(): array {
        return ['index' => Pages\ListMoodEntries::route('/')];
    }
}
