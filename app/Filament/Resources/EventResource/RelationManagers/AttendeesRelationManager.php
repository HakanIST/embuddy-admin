<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AttendeesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendees';
    protected static ?string $title = 'Attendees';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.fullName')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.department')
                    ->label('Department'),
                Tables\Columns\TextColumn::make('createdAt')
                    ->label('Joined At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('createdAt', 'desc')
            ->actions([
                \Filament\Actions\DeleteAction::make()->label('Remove'),
            ])
            ->emptyStateHeading('No attendees yet')
            ->emptyStateDescription('Users can join this event from the mobile app.');
    }
}
