<?php
namespace App\Filament\Resources;
use App\Filament\Resources\MentorAssignmentResource\Pages;
use App\Models\MentorAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MentorAssignmentResource extends Resource {
    protected static ?string $model = MentorAssignment::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static string | \UnitEnum | null $navigationGroup = 'Mentor Management';
    protected static ?int $navigationSort = 21;
    protected static ?string $navigationLabel = 'Assignments';
    protected static ?string $modelLabel = 'Mentor Assignment';

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Section::make('Assignment Details')->schema([
                Forms\Components\Select::make('mentorId')
                    ->label('Mentor')
                    ->relationship('mentor.user', 'fullName')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('menteeId')
                    ->label('Student (Mentee)')
                    ->relationship('mentee', 'fullName')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'paused' => 'Paused',
                        'completed' => 'Completed',
                    ])
                    ->default('active')
                    ->required(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('mentor.user.fullName')->label('Mentor')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('mentee.fullName')->label('Student')->searchable(),
            Tables\Columns\TextColumn::make('mentee.department')->label('Department'),
            Tables\Columns\BadgeColumn::make('status')->color(fn ($state) => match($state) {
                'active' => 'success',
                'paused' => 'warning',
                'completed' => 'gray',
                default => 'gray',
            }),
            Tables\Columns\TextColumn::make('messages_count')
                ->counts('messages')
                ->label('Messages')
                ->badge()
                ->color('info'),
            Tables\Columns\TextColumn::make('assignedAt')->dateTime()->sortable()->label('Assigned'),
        ])
        ->defaultSort('assignedAt', 'desc')
        ->filters([
            Tables\Filters\SelectFilter::make('status')->options([
                'active' => 'Active',
                'paused' => 'Paused',
                'completed' => 'Completed',
            ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListMentorAssignments::route('/'),
            'create' => Pages\CreateMentorAssignment::route('/create'),
            'edit' => Pages\EditMentorAssignment::route('/{record}/edit'),
        ];
    }
}
