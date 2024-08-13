<?php

namespace App\Filament\Resources\RunningTimeResource\Pages;

use App\Filament\Resources\RunningTimeResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRunningTimes extends ListRecords
{
    protected static string $resource = RunningTimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Pesanan')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
