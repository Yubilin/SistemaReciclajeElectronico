<?php

namespace App\Filament\Resources\MaterialRecibidoResource\Pages;

use App\Filament\Resources\MaterialRecibidoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterialRecibidos extends ListRecords
{
    protected static string $resource = MaterialRecibidoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
