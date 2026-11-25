<?php

namespace App\Filament\Resources\MaterialRecibidoResource\Pages;

use App\Filament\Resources\MaterialRecibidoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterialRecibido extends EditRecord
{
    protected static string $resource = MaterialRecibidoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
