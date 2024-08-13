<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use App\Filament\Resources\ProdukResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProduk extends ViewRecord
{
    protected static string $resource = ProdukResource::class;
    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Produk')
                ->icon('heroicon-o-pencil-square'),
            DeleteAction::make()
                ->label('Hapus Produk')
                ->icon('heroicon-o-trash'),
        ];
    }
}
