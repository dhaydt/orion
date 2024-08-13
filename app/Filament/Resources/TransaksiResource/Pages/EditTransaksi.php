<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Models\Transaksi;
use App\Models\TransaksiProduk;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaksi extends EditRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Transaksi')
                ->icon('heroicon-o-pencil-square'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
        $data['jumlah_item'] = count($data['transaksiProduk']);
        $total = 0;
        foreach ($data['transaksiProduk'] as $transaksiProduk) {
            $total += $transaksiProduk['sub_total'];
        }
    }

    protected function afterSave()
    {
        $transaksi = Transaksi::find($this->getRecord()->id);
        if ($transaksi) {
            $transaksi->jumlah_item = $transaksi->transaksiProduk->count();
            $total = 0;
            foreach ($transaksi->transaksiProduk as $transaksiProduk) {
                $total += $transaksiProduk->sub_total;
            }
            $transaksi->total = $total;
            $transaksi->save();
        }
    }
}
