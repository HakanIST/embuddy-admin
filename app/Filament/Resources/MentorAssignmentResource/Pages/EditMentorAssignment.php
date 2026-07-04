<?php
namespace App\Filament\Resources\MentorAssignmentResource\Pages;
use App\Filament\Resources\MentorAssignmentResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditMentorAssignment extends EditRecord {
    protected static string $resource = MentorAssignmentResource::class;
    protected function getHeaderActions(): array {
        return [Actions\DeleteAction::make()];
    }
}
