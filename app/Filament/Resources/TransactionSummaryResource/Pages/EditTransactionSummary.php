<?php

namespace App\Filament\Resources\TransactionSummaryResource\Pages;

use App\Filament\Resources\TransactionSummaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionSummary extends EditRecord
{
    protected static string $resource = TransactionSummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
