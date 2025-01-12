<?php

namespace App\Filament\Resources\ProductTransactionSummaryResource\Pages;

use App\Filament\Resources\ProductTransactionSummaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductTransactionSummary extends EditRecord
{
    protected static string $resource = ProductTransactionSummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
