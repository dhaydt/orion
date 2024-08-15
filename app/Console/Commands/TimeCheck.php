<?php

namespace App\Console\Commands;

use App\Models\Meja;
use App\Models\RunningTime;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Tables\Table;
use Illuminate\Console\Command;

class TimeCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Time out checker running time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d H:i');

        $runnings = RunningTime::where('status_pembayaran', 0)->whereNotNull('waktu_selesai')->whereDate('waktu_selesai', '<=', $now)->get();

        foreach ($runnings as $key => $r) {
            $user = User::get();

            $selesai = Carbon::parse($r['waktu_selesai'])->format('Y-m-d H:i');

            if($selesai < $now){

                $name = $r['nama_penyewa'] ?? $r['member']['nama'];

                foreach($user as $u){
                    Notification::make()
                    ->title('Waktu bermain atas nama '. $name . ' telah habis, dengan no meja '.$r['nomor_meja'])
                    ->sendToDatabase($u);
                }

            }

        }

        \Log::info("Time checked on ".date('d-m-Y H:i'));
    }
}
