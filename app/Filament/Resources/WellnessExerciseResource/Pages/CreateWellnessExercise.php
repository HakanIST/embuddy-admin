<?php
namespace App\Filament\Resources\WellnessExerciseResource\Pages;
use App\Filament\Resources\WellnessExerciseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWellnessExercise extends CreateRecord {
    protected static string $resource = WellnessExerciseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array {
        if (isset($data['steps_array'])) {
            $data['steps'] = json_encode(array_values($data['steps_array']));
            unset($data['steps_array']);
        }
        return $data;
    }
}
