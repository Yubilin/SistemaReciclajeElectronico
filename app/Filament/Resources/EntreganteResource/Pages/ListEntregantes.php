<?php

namespace App\Filament\Resources\EntreganteResource\Pages;

use App\Filament\Resources\EntreganteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEntregantes extends ListRecords
{
    protected static string $resource = EntreganteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
