<?php

namespace App\CPU;

use App\Models\Config;
use App\Models\ProductTransactionSummary;
use App\Models\RunningTime;
use App\Models\TransactionSummary;
use App\Models\Transaksi;
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
        $now = Carbon::now()->addDay()->format('Y-m-d H:i');
        $from = Carbon::now()->subDays(20)->format('Y-m-d H:i');

        $dates = RunningTime::whereBetween('created_at', [$from, $now])->get()->pluck('created_at')->toArray();

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

    public static function countSummaryProduct()
    {
        $now = Carbon::now()->addDay()->format('Y-m-d H:i');
        $from = Carbon::now()->subDays(20)->format('Y-m-d H:i');

        $dates = Transaksi::whereBetween('created_at', [$from, $now])->get()->pluck('created_at')->toArray();

        foreach ($dates as $key => $d) {
            // $transactions = Transaksi::where('status_pembayaran', 1)->whereDate('created_at', $d)->get();
            $transactions = Transaksi::whereDate('created_at', $d)->get();
            $summary = [];
            $transaction = 0;

            foreach ($transactions as $key => $t) {
                $total = $t->total;
                array_push($summary, $total);
                $transaction += 1;
            }

            $check = ProductTransactionSummary::wheredate('date', $d)->first();

            if (!$check) {
                $check = new ProductTransactionSummary();
                $check->date = $d->format('Y-m-d H:i');
            }

            $check->total = array_sum($summary);
            $check->transaction = $transaction;
            $check->save();
        }

        Notification::make()
            ->title('Rekap transaksi produk berhasil diperbaharui')
            ->success()
            ->send();
    }

    public static function getPrice($name){
        $price = 0;

        $config = Config::where('name', $name)->first();

        if($config){
            $price = $config->value;
        }

        return $price;
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
