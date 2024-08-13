<?php

namespace App\Filament\Resources\RunningTimeResource\Pages;

use App\Filament\Resources\RunningTimeResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditRunningTime extends EditRecord
{
    protected static string $resource = RunningTimeResource::class;

    protected static ?string $title = 'Ubah / Tambah Pesanan';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Pesanan')
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['waktu_mulai_picker'] = $data['waktu_mulai'];
        $data['waktu_selesai_picker'] = $data['waktu_selesai'];
        $data['waktu_mulai'] = false;
        $data['waktu_selesai'] = false;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['waktu_mulai'] == null || $data['waktu_mulai'] == false) && $data['waktu_mulai_picker'] == null) {
            Notification::make()
                ->title('Waktu mulai belum ditentukan !')
                ->danger()
                ->icon('heroicon-o-x-circle')
                ->send();
            $this->halt();
        } elseif ($data['nama_penyewa'] == null && $data['id_member'] == null) {
            Notification::make()
                ->title('Nama penyewa tidak boleh kosong')
                ->danger()
                ->icon('heroicon-o-x-circle')
                ->send();
            $this->halt();
        }

        if ($data['waktu_mulai'] == 1 || $data['waktu_mulai'] == true) {
            $data['waktu_mulai'] = now();
        } elseif ($data['waktu_mulai_picker'] != null) {
            $data['waktu_mulai'] = $data['waktu_mulai_picker'];
        }

        if ($data['waktu_selesai'] == 1 || $data['waktu_selesai'] == true) {
            $data['waktu_selesai'] = now();
            $jumlah_waktu_running = Carbon::parse($data['waktu_mulai'])
                ->diffInMinutes($data['waktu_selesai']);

            $data['waktu_running'] = $jumlah_waktu_running;
        } elseif ($data['waktu_selesai_picker'] != null) {
            $data['waktu_selesai'] = $data['waktu_selesai_picker'];
            $jumlah_waktu_running = Carbon::parse($data['waktu_mulai'])
                ->diffInMinutes($data['waktu_selesai']);

            $data['waktu_running'] = $jumlah_waktu_running;
        } else {
            $data['waktu_selesai'] = null;
            $data['waktu_running'] = 0;
        }

        $data['id_user'] = Auth::id();
        return $data;
    }
}
