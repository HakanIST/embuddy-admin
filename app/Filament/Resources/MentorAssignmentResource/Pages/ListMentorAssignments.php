<?php
namespace App\Filament\Resources\MentorAssignmentResource\Pages;
use App\Filament\Resources\MentorAssignmentResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListMentorAssignments extends ListRecords {
    protected static string $resource = MentorAssignmentResource::class;
    protected function getHeaderActions(): array {
        return [Actions\CreateAction::make()];
    }
}
