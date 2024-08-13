<?php

namespace App\Filament\Resources\MejaResource\Pages;

use App\Filament\Resources\MejaResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMejas extends ListRecords
{
    protected static string $resource = MejaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Meja')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
