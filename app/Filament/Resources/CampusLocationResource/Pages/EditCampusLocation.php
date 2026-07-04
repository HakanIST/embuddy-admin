<?php
namespace App\Filament\Resources\CampusLocationResource\Pages;
use App\Filament\Resources\CampusLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditCampusLocation extends EditRecord {
    protected static string $resource = CampusLocationResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
