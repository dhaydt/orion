<?php

namespace App\Filament\Resources\ProductTransactionSummaryResource\Pages;

use App\CPU\Helpers;
use App\Filament\Resources\ProductTransactionSummaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductTransactionSummaries extends ListRecords
{
    protected static string $resource = ProductTransactionSummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('refresh')
                ->label('Hitung Ulang')
                ->action(fn () => Helpers::countSummaryProduct())
        ];
    }
}
