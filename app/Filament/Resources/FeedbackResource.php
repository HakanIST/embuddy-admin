<?php
namespace App\Filament\Resources;
use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class FeedbackResource extends Resource {
    protected static ?string $model = Feedback::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static string | \UnitEnum | null $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationLabel = 'Feedback';

    public static function canCreate(): bool { return false; }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('user.fullName')->label('Student')->searchable(),
            Tables\Columns\TextColumn::make('user.email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('subject')->searchable()->limit(40)->weight('bold'),
            Tables\Columns\TextColumn::make('message')->limit(60)->toggleable(),
            Tables\Columns\TextColumn::make('createdAt')->dateTime()->sortable()->label('Date'),
        ])
        ->defaultSort('createdAt', 'desc')
        ->actions([
            Tables\Actions\ViewAction::make(),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist {
        return $infolist->schema([
            Infolists\Components\Section::make('Feedback Details')->schema([
                Infolists\Components\TextEntry::make('user.fullName')->label('Student'),
                Infolists\Components\TextEntry::make('user.email')->label('Email'),
                Infolists\Components\TextEntry::make('subject')->weight('bold'),
                Infolists\Components\TextEntry::make('message')->columnSpanFull(),
                Infolists\Components\TextEntry::make('createdAt')->dateTime()->label('Submitted At'),
            ])->columns(2),
        ]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'view' => Pages\ViewFeedback::route('/{record}'),
        ];
    }
}
