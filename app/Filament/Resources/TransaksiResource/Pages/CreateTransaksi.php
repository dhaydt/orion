<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Models\Transaksi;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
        $data['jumlah_item'] = count($data['transaksiProduk']);
        $total = 0;
        foreach ($data['transaksiProduk'] as $transaksiProduk) {
            $total += $transaksiProduk['sub_total'];
        }
    }

    protected function afterCreate()
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
