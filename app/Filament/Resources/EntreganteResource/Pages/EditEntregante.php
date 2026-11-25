<?php

namespace App\Filament\Resources\EntreganteResource\Pages;

use App\Filament\Resources\EntreganteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEntregante extends EditRecord
{
    protected static string $resource = EntreganteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
