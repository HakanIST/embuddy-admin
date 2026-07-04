<?php

namespace App\Filament\Resources\EmbuddyUserResource\Pages;

use App\Filament\Resources\EmbuddyUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmbuddyUsers extends ListRecords
{
    protected static string $resource = EmbuddyUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
