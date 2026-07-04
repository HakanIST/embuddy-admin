<?php
namespace App\Filament\Resources\WordOfDayResource\Pages;
use App\Filament\Resources\WordOfDayResource;
use Filament\Resources\Pages\CreateRecord;
class CreateWordOfDay extends CreateRecord {
    protected static string $resource = WordOfDayResource::class;
}
