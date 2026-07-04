<?php
namespace App\Filament\Resources\WordOfDayResource\Pages;
use App\Filament\Resources\WordOfDayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditWordOfDay extends EditRecord {
    protected static string $resource = WordOfDayResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
