<?php
namespace App\Filament\Resources;
use App\Filament\Resources\CampusLocationResource\Pages;
use App\Models\CampusLocation;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CampusLocationResource extends Resource {
    protected static ?string $model = CampusLocation::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';
    protected static string | \UnitEnum | null $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Schemas\Components\Section::make()->schema([
                Schemas\Components\TextInput::make('name')->required()->maxLength(255),
                Schemas\Components\Select::make('campus')->options([
                    'Üsküdar' => 'Üsküdar', 'Altunizade' => 'Altunizade', 'Çekmeköy' => 'Çekmeköy',
                ])->required(),
                Schemas\Components\TextInput::make('building')->maxLength(100),
                Schemas\Components\TextInput::make('floor')->maxLength(50),
                Schemas\Components\TextInput::make('schedule')->maxLength(100)->placeholder('Mon-Sat, 08:00-22:00'),
                Schemas\Components\Select::make('category')->options([
                    'library' => 'Library', 'cafe' => 'Cafe', 'lab' => 'Lab',
                    'health' => 'Health', 'office' => 'Office',
                ]),
                Schemas\Components\TextInput::make('latitude')->numeric(),
                Schemas\Components\TextInput::make('longitude')->numeric(),
                Schemas\Components\Toggle::make('hasWheelchairAccess')->label('Wheelchair Access'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('campus')->sortable()->badge()->color(fn ($state) => match($state) {
                'Üsküdar' => 'success', 'Altunizade' => 'info', 'Çekmeköy' => 'warning', default => 'gray'
            }),
            Tables\Columns\TextColumn::make('category')->badge(),
            Tables\Columns\TextColumn::make('building'),
            Tables\Columns\IconColumn::make('hasWheelchairAccess')->boolean()->label('♿'),
        ])
        ->filters([
            \Filament\Tables\Filters\SelectFilter::make('campus')->options([
                'Üsküdar' => 'Üsküdar', 'Altunizade' => 'Altunizade', 'Çekmeköy' => 'Çekmeköy',
            ]),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListCampusLocations::route('/'),
            'create' => Pages\CreateCampusLocation::route('/create'),
            'edit' => Pages\EditCampusLocation::route('/{record}/edit'),
        ];
    }
}
