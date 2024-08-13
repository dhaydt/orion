<?php

namespace App\Filament\Resources\RunningTimeResource\Pages;

use App\Filament\Resources\RunningTimeResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRunningTime extends ViewRecord
{
    protected static string $resource = RunningTimeResource::class;
    protected static ?string $title = 'Detail Pesanan';
    protected function getActions(): array
    {
        return [
            EditAction::make()
                ->label('Tambah pesanan')
                ->icon('heroicon-o-pencil-square'),
            DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-o-trash')
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['waktu_mulai'] = false;
        $data['waktu_selesai'] = false;
        $data['waktu_mulai_picker'] = $data['waktu_mulai'];
        $data['waktu_selesai_picker'] = $data['waktu_selesai'];
        return $data;
    }
}
