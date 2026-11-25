<?php

namespace App\Filament\Resources\RecuperacionResource\Pages;

use App\Filament\Resources\RecuperacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecuperacion extends EditRecord
{
    protected static string $resource = RecuperacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
