<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmbuddyUserResource\Pages;
use App\Models\EmbuddyUser;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmbuddyUserResource extends Resource
{
    protected static ?string $model = EmbuddyUser::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static string | \UnitEnum | null $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Students';
    protected static ?string $modelLabel = 'Student';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Personal Information')->schema([
                Forms\Components\TextInput::make('fullName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->maxLength(100),
                Forms\Components\TextInput::make('year')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(6),
                Forms\Components\Select::make('language')
                    ->options([
                        'en' => 'English',
                        'tr' => 'Türkçe',
                        'ar' => 'العربية',
                    ])
                    ->default('en'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('Gamification')->schema([
                Forms\Components\TextInput::make('xpPoints')
                    ->numeric()
                    ->default(0)
                    ->label('XP Points'),
                Forms\Components\TextInput::make('level')
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('isActive')
                    ->default(true)
                    ->label('Active'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fullName')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('xpPoints')
                    ->sortable()
                    ->label('XP')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('level')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('isActive')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('createdAt')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('isActive')
                    ->label('Active'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmbuddyUsers::route('/'),
            'create' => Pages\CreateEmbuddyUser::route('/create'),
            'edit' => Pages\EditEmbuddyUser::route('/{record}/edit'),
        ];
    }
}
