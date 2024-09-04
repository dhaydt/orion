<?php

namespace App\CPU;

use App\Models\RunningTime;
use App\Models\TransactionSummary;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class Helpers
{
    public static function appName()
    {
        return 'Orion Billiard';
    }

    public static function dateFormat($date)
    {
        return Carbon::parse($date)->format('d-m-Y H:i');
    }

    public static function countSummary()
    {
        $dates = RunningTime::get()->pluck('created_at')->toArray();

        foreach ($dates as $key => $d) {
            $transactions = RunningTime::where('status_pembayaran', 1)->whereDate('created_at', $d)->get();
            $summary = [];
            $transaction = 0;

            foreach ($transactions as $key => $t) {
                $total = $t->total();
                array_push($summary, $total);
                $transaction += 1;
            }

            $check = TransactionSummary::wheredate('date', $d)->first();

            if (!$check) {
                $check = new TransactionSummary();
                $check->date = $d->format('Y-m-d H:i');
            }

            $check->total = array_sum($summary);
            $check->transaction = $transaction;
            $check->save();
        }

        Notification::make()
            ->title('Rekap transaksi berhasil diperbaharui')
            ->success()
            ->send();
    }

    public static function dateFormat2($date, $type)
    {

        if ($type == 'date') {
            $d = Carbon::parse($date)->format('d-m-Y');
        } else {
            $d = Carbon::parse($date)->format('d-m-Y H:i');
        }

        return $d;
    }
}
