<?php

namespace App\Filament\Resources\RecuperacionResource\Pages;

use App\Filament\Resources\RecuperacionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecuperacions extends ListRecords
{
    protected static string $resource = RecuperacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
