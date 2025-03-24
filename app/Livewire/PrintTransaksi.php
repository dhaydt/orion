<?php

namespace App\Livewire;

use App\CPU\Helpers;
use App\Models\RunningTime;
use App\Models\Transaksi;
use App\Models\TransaksiProduk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PrintTransaksi extends Component
{
    public $id_transaksi;
    public $transaksi;
    public $items;
    public $kasir;
    public $order;

    public function render()
    {
        $this->kasir = Auth::user()->name ?? 'Invalid Kasir';
        $this->order = [
            'id' => $this->transaksi['id'],
            'id_user' => Auth::user()->id,
            'status_pembayaran' => $this->transaksi->status_pembayaran,
            'produk' => $this->transaksi->transaksiProduk,
            'total' => 'Rp. ' . number_format($this->transaksi->total, 0, ',', '.'),
            'meja' => $this->transaksi->meja ?? '-',
            'tanggal_transaksi' => Carbon::parse($this->transaksi->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY H:m:s')
        ];

        $this->items = TransaksiProduk::where('id_transaksi', $this->id_transaksi)->get();
        return view('livewire.print-transaksi', $this->transaksi);
    }

    public function mount($id)
    {
        $this->id_transaksi = $id;
        $this->transaksi = Transaksi::find($this->id_transaksi);
    }

    public function bayar()
    {
        $record = Transaksi::find($this->id_transaksi);
        $record->update([
            'status_pembayaran' => 1,
        ]);

        $this->dispatch('counted_order', 1, 'Order berhasil dibayar');
    }
}
