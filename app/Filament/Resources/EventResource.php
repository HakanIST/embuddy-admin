<?php
namespace App\Filament\Resources;
use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource {
    protected static ?string $model = Event::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static string | \UnitEnum | null $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->rows(3),
                Forms\Components\TextInput::make('location')->maxLength(255),
                Forms\Components\DatePicker::make('eventDate')->required()->native(false),
                Forms\Components\TimePicker::make('eventTime')->native(false),
                Forms\Components\Select::make('tag')->options([
                    'New Students' => 'New Students',
                    'Social' => 'Social',
                    'Learning' => 'Learning',
                    'Cultural' => 'Cultural',
                ]),
                Forms\Components\TextInput::make('attendeeCount')->numeric()->default(0)->label('Attendees'),
                Forms\Components\TextInput::make('imageUrl')->url()->maxLength(500)->label('Image URL'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(30),
            Tables\Columns\TextColumn::make('eventDate')->sortable()->date(),
            Tables\Columns\TextColumn::make('eventTime'),
            Tables\Columns\TextColumn::make('tag')->badge()->color(fn ($state) => match($state) {
                'Social' => 'success', 'Learning' => 'info', 'New Students' => 'warning', default => 'gray'
            }),
            Tables\Columns\TextColumn::make('attendeeCount')->sortable()->label('Attendees'),
        ])
        ->filters([
            \Filament\Tables\Filters\SelectFilter::make('tag')->options([
                'New Students' => 'New Students', 'Social' => 'Social', 'Learning' => 'Learning',
            ]),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
