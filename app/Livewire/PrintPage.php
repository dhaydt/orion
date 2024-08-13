<?php

namespace App\Livewire;

use App\CPU\Helpers;
use App\Models\RunningTime;
use App\Models\TransaksiProduk;
use Carbon\Carbon;
use Livewire\Component;

class PrintPage extends Component
{
    public $id_tr;
    public $order;
    public $items;
    public $kasir;
    public $running;

    public function render()
    {
        $id = $this->id_tr;
        $data = RunningTime::find($id);
        $this->kasir = $data->user->name ?? 'Invalid Kasir';
        $this->running = RunningTime::find($id);
        $this->order = [
            'id' => $data['id'],
            'mulai' => Helpers::dateFormat($data->waktu_mulai),
            'selesai' => $data->waktu_selesai != null ? Helpers::dateFormat($data->waktu_selesai) : null,
            'penyewa' => $data->id_member ? $data->member->nama.' (Member)' : ($data->nama_penyewa ?? 'Tidak ada nama'),
            'meja' => $data->nomor_meja,
            'id_user' => $data->id_user,
            'id_member' => $data->id_member,
            'waktu' => $data->waktu_running . ' menit',
            'harga_per_jam' => 'Rp. ' . number_format($data->harga_per_jam),
            'status_pembayaran' => $data->status_pembayaran,
            'produk' => $data->produk,
            'total' => 'Rp. ' . number_format($data->total())
        ];

        $this->items = TransaksiProduk::where('id_running_time', $id)->get();
        return view('livewire.print-page', $data);
    }

    public function mount($id){
        $this->id_tr = $id;
    }

    public function bayar(){
        $record = RunningTime::find($this->id_tr);
        $record->update([
            'status_pembayaran' => 1,
            'id_user' => auth()->id()
        ]);

        $this->dispatch('counted_order', 1, 'Order berhasil dibayar');
    }

    public function countOrder(){
        $waktu_selesai = now();
        $record = RunningTime::find($this->id_tr);
        $minutes = Carbon::parse($record->waktu_mulai)
            ->diffInMinutes($waktu_selesai);
        $record->update([
            'waktu_selesai' => $waktu_selesai,
            'waktu_running' => $minutes,
            'id_user' => auth()->id()
        ]);
        $this->dispatch('counted_order', 1, 'Order berhasil dihitung');
    }
}
