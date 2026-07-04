<?php
namespace App\Filament\Resources;
use App\Filament\Resources\MentorResource\Pages;
use App\Models\Mentor;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MentorResource extends Resource {
    protected static ?string $model = Mentor::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';
    protected static string | \UnitEnum | null $navigationGroup = 'Mentor Management';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Mentors';

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Forms\Components\Section::make('Mentor Details')->schema([
                Forms\Components\Select::make('userId')
                    ->label('User Account')
                    ->relationship('user', 'fullName')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('bio')
                    ->label('Biography')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('languages')
                    ->label('Languages (comma separated)')
                    ->placeholder('English, Turkish, Arabic'),
                Forms\Components\TextInput::make('maxMentees')
                    ->label('Max Mentees')
                    ->numeric()
                    ->default(5)
                    ->minValue(1)
                    ->maxValue(20),
                Forms\Components\Toggle::make('isActive')
                    ->label('Active')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('user.fullName')->label('Name')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('user.email')->label('Email')->searchable(),
            Tables\Columns\TextColumn::make('user.department')->label('Department'),
            Tables\Columns\TextColumn::make('languages')->limit(30),
            Tables\Columns\TextColumn::make('activeAssignments_count')
                ->counts('activeAssignments')
                ->label('Active Mentees')
                ->badge()
                ->color('success'),
            Tables\Columns\TextColumn::make('maxMentees')->label('Max'),
            Tables\Columns\IconColumn::make('isActive')->boolean()->label('Active'),
            Tables\Columns\TextColumn::make('createdAt')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])
        ->defaultSort('id', 'desc')
        ->filters([
            Tables\Filters\TernaryFilter::make('isActive')->label('Active'),
        ])
        ->actions([
            \Filament\Actions\EditAction::make(),
        ])
        ->bulkActions([
            \Filament\Actions\BulkActionGroup::make([
                \Filament\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListMentors::route('/'),
            'create' => Pages\CreateMentor::route('/create'),
            'edit' => Pages\EditMentor::route('/{record}/edit'),
        ];
    }
}
