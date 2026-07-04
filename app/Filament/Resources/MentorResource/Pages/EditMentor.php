<?php
namespace App\Filament\Resources\MentorResource\Pages;
use App\Filament\Resources\MentorResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditMentor extends EditRecord {
    protected static string $resource = MentorResource::class;
    protected function getHeaderActions(): array {
        return [Actions\DeleteAction::make()];
    }
}
