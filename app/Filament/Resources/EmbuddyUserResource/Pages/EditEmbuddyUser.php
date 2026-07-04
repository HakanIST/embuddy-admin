<?php
namespace App\Filament\Resources\EmbuddyUserResource\Pages;
use App\Filament\Resources\EmbuddyUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmbuddyUser extends EditRecord
{
    protected static string $resource = EmbuddyUserResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
