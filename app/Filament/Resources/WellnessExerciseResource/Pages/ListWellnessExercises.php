<?php
namespace App\Filament\Resources\WellnessExerciseResource\Pages;
use App\Filament\Resources\WellnessExerciseResource;
use Filament\Resources\Pages\ListRecords;

class ListWellnessExercises extends ListRecords {
    protected static string $resource = WellnessExerciseResource::class;
    protected function getHeaderActions(): array {
        return [\Filament\Actions\CreateAction::make()];
    }
}
