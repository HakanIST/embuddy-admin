<?php
namespace App\Filament\Resources;
use App\Filament\Resources\MentorMessageResource\Pages;
use App\Models\MentorMessage;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MentorMessageResource extends Resource {
    protected static ?string $model = MentorMessage::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static string | \UnitEnum | null $navigationGroup = 'Mentor Management';
    protected static ?int $navigationSort = 22;
    protected static ?string $navigationLabel = 'Messages';
    protected static ?string $modelLabel = 'Mentor Message';

    public static function canCreate(): bool { return false; }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('sender.fullName')->label('From')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('assignment.mentor.user.fullName')->label('Mentor'),
            Tables\Columns\TextColumn::make('assignment.mentee.fullName')->label('Student'),
            Tables\Columns\TextColumn::make('message')->limit(50),
            Tables\Columns\IconColumn::make('isRead')->boolean()->label('Read'),
            Tables\Columns\TextColumn::make('createdAt')->dateTime()->sortable()->label('Sent'),
        ])
        ->defaultSort('createdAt', 'desc')
        ->filters([
            Tables\Filters\TernaryFilter::make('isRead')->label('Read Status'),
        ])
        ->actions([
            \Filament\Actions\Action::make('markRead')
                ->label('Mark Read')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn ($record) => !$record->isRead)
                ->action(fn ($record) => $record->update(['isRead' => true])),
        ]);
    }

    public static function getPages(): array {
        return ['index' => Pages\ListMentorMessages::route('/')];
    }
}
