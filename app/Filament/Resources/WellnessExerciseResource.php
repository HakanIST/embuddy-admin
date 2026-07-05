<?php
namespace App\Filament\Resources;
use App\Filament\Resources\WellnessExerciseResource\Pages;
use App\Models\WellnessExercise;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WellnessExerciseResource extends Resource {
    protected static ?string $model = WellnessExercise::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-heart';
    protected static string | \UnitEnum | null $navigationGroup = 'Wellness';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Exercises';

    public static function form(Schema $schema): Schema {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Exercise Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->options([
                        'breathing' => '🫁 Breathing',
                        'meditation' => '🧘 Meditation',
                        'muscle_relaxation' => '💪 Muscle Relaxation',
                        'grounding' => '🌿 Grounding',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('icon')
                    ->maxLength(100)
                    ->placeholder('SF Symbol name (e.g. wind)')
                    ->helperText('iOS SF Symbol name'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('durationSeconds')
                    ->numeric()
                    ->required()
                    ->default(60)
                    ->suffix('seconds')
                    ->label('Total Duration'),
                Forms\Components\TextInput::make('sortOrder')
                    ->numeric()
                    ->default(0)
                    ->label('Sort Order'),
                Forms\Components\Toggle::make('isActive')
                    ->default(true)
                    ->label('Active'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('Exercise Steps')
                ->description('Define the step-by-step flow. Each step has an instruction, duration, and type.')
                ->schema([
                    Forms\Components\Repeater::make('steps_array')
                        ->label('')
                        ->schema([
                            Forms\Components\TextInput::make('instruction')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('durationSeconds')
                                ->numeric()
                                ->required()
                                ->default(4)
                                ->suffix('sec')
                                ->label('Duration'),
                            Forms\Components\Select::make('type')
                                ->options([
                                    'prepare' => '🎯 Prepare',
                                    'inhale' => '🫁 Inhale',
                                    'hold' => '⏸ Hold',
                                    'exhale' => '💨 Exhale',
                                    'observe' => '👁 Observe',
                                    'relax' => '😌 Relax',
                                    'complete' => '✅ Complete',
                                ])
                                ->required(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Add Step')
                        ->reorderable()
                        ->collapsible()
                        ->defaultItems(3)
                        ->afterStateHydrated(function ($component, $record) {
                            if ($record && $record->steps) {
                                $steps = json_decode($record->steps, true) ?: [];
                                $component->state($steps);
                            }
                        }),
                ]),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(30),
            Tables\Columns\TextColumn::make('category')->badge()->color(fn ($state) => match($state) {
                'breathing' => 'info',
                'meditation' => 'success',
                'muscle_relaxation' => 'warning',
                'grounding' => 'primary',
                default => 'gray'
            }),
            Tables\Columns\TextColumn::make('durationSeconds')
                ->formatStateUsing(fn ($state) => intdiv($state, 60) . ':' . str_pad($state % 60, 2, '0', STR_PAD_LEFT))
                ->label('Duration'),
            Tables\Columns\IconColumn::make('isActive')->boolean()->label('Active'),
            Tables\Columns\TextColumn::make('sortOrder')->sortable()->label('#'),
        ])
        ->defaultSort('sortOrder')
        ->filters([
            \Filament\Tables\Filters\SelectFilter::make('category')->options([
                'breathing' => 'Breathing',
                'meditation' => 'Meditation',
                'muscle_relaxation' => 'Muscle Relaxation',
                'grounding' => 'Grounding',
            ]),
        ])
        ->actions([\Filament\Actions\EditAction::make(), \Filament\Actions\DeleteAction::make()])
        ->bulkActions([\Filament\Actions\BulkActionGroup::make([\Filament\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListWellnessExercises::route('/'),
            'create' => Pages\CreateWellnessExercise::route('/create'),
            'edit' => Pages\EditWellnessExercise::route('/{record}/edit'),
        ];
    }

    // Mutate form data before saving — convert steps_array to JSON string
    public static function mutateFormDataBeforeCreate(array $data): array {
        return static::convertSteps($data);
    }

    public static function mutateFormDataBeforeSave(array $data): array {
        return static::convertSteps($data);
    }

    protected static function convertSteps(array $data): array {
        if (isset($data['steps_array'])) {
            $data['steps'] = json_encode(array_values($data['steps_array']));
            unset($data['steps_array']);
        }
        return $data;
    }
}
