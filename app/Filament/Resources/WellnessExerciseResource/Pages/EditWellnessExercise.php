<?php
namespace App\Filament\Resources\WellnessExerciseResource\Pages;
use App\Filament\Resources\WellnessExerciseResource;
use Filament\Resources\Pages\EditRecord;

class EditWellnessExercise extends EditRecord {
    protected static string $resource = WellnessExerciseResource::class;

    protected function mutateFormDataBeforeSave(array $data): array {
        if (isset($data['steps_array'])) {
            $data['steps'] = json_encode(array_values($data['steps_array']));
            unset($data['steps_array']);
        }
        return $data;
    }
}
