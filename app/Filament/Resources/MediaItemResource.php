<?php
namespace App\Filament\Resources;
use App\Filament\Resources\MediaItemResource\Pages;
use App\Models\MediaItem;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaItemResource extends Resource {
    protected static ?string $model = MediaItem::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-play-circle';
    protected static string | \UnitEnum | null $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            Schemas\Components\Section::make()->schema([
                Schemas\Components\TextInput::make('title')->required()->maxLength(255),
                Schemas\Components\Select::make('mediaType')->options([
                    'podcast' => '🎙 Podcast', 'book' => '📚 Book', 'video' => '🎬 Video',
                ])->required()->label('Type'),
                Schemas\Components\TextInput::make('creator')->maxLength(255),
                Schemas\Components\TextInput::make('episode')->numeric()->label('Episode #'),
                Schemas\Components\TextInput::make('durationMinutes')->numeric()->label('Duration (min)'),
                Schemas\Components\TextInput::make('thumbnailUrl')->url()->maxLength(500),
                Schemas\Components\TextInput::make('mediaUrl')->url()->maxLength(500),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(30),
            Tables\Columns\TextColumn::make('mediaType')->badge()->color(fn ($state) => match($state) {
                'podcast' => 'success', 'book' => 'info', 'video' => 'warning', default => 'gray'
            })->label('Type'),
            Tables\Columns\TextColumn::make('creator')->searchable(),
            Tables\Columns\TextColumn::make('episode')->label('Ep'),
            Tables\Columns\TextColumn::make('durationMinutes')->suffix(' min')->label('Duration'),
        ])
        ->filters([
            \Filament\Tables\Filters\SelectFilter::make('mediaType')->options([
                'podcast' => 'Podcast', 'book' => 'Book', 'video' => 'Video',
            ])->label('Type'),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListMediaItems::route('/'),
            'create' => Pages\CreateMediaItem::route('/create'),
            'edit' => Pages\EditMediaItem::route('/{record}/edit'),
        ];
    }
}
