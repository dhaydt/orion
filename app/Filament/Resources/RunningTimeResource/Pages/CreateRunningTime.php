<?php

namespace App\Filament\Resources\RunningTimeResource\Pages;

use App\Filament\Resources\RunningTimeResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRunningTime extends CreateRecord
{
    protected static string $resource = RunningTimeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['paket'] == 'personal') {
            if (($data['waktu_mulai'] == null || $data['waktu_mulai'] == false) && $data['waktu_mulai_picker'] == null) {
                Notification::make()
                    ->title('Waktu mulai belum di tentukan !')
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

                if ($jumlah_waktu_running == 59) {
                    $jumlah_waktu_running = 60;
                }

                $data['waktu_running'] = $jumlah_waktu_running;
            } else {
                $data['waktu_selesai'] = null;
                $data['waktu_running'] = 0;
            }
        } else {
            $data['waktu_mulai'] = now();

            if($data['paket'] == 1){
                $data['waktu_selesai'] = Carbon::parse($data['waktu_mulai'])->addHour();
            }elseif($data['paket'] == 2){
                $data['waktu_selesai'] = Carbon::parse($data['waktu_mulai'])->addHours(2);
            }elseif($data['paket'] == 3){
                $data['waktu_selesai'] = Carbon::parse($data['waktu_mulai'])->addHours(3);
            }elseif($data['paket'] == 4){
                $data['waktu_selesai'] = Carbon::parse($data['waktu_mulai'])->addHours(4);
            }

            $jumlah_waktu_running = Carbon::parse($data['waktu_mulai'])
                                        ->diffInMinutes($data['waktu_selesai']);
            $data['waktu_running'] = $jumlah_waktu_running;
        }


        $data['id_user'] = Auth::id();
        return $data;
    }
}
