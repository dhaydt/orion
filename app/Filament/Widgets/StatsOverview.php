<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Models\Produk;
use App\Models\RunningTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlahMember = Member::count();
        $arrayJumlahMember = [];
        $arrayJumlahNilaiTransaksi = [];
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $carbonPeriod = CarbonPeriod::create($startWeek, $endWeek);
        foreach ($carbonPeriod as $periode) {
            $dataMember = Member::whereDate('created_at', $periode)
                ->count();
            array_push($arrayJumlahMember, $dataMember);

            $listRunningTime = RunningTime::whereDate('created_at', $periode)
                ->get();
            $totalNilaiTransaksi = 0;
            foreach ($listRunningTime as $runningTime) {
                $totalNilaiTransaksi += $runningTime->total();
            }

            array_push($arrayJumlahNilaiTransaksi, $totalNilaiTransaksi);
        }
        $jumlahProduk = Produk::count();
        $jumlahRunningTime = RunningTime::where('waktu_selesai', '!=', null)
            ->count();

        $nowTransaksi = 0;
        $transaksiNow = RunningTime::where('status_pembayaran', 1)->whereDate('created_at', now())->get();
        foreach ($transaksiNow as $tn) {
            $nowTransaksi += $tn->total();
        }

        $jumlahNilaiTransaksi = 0;
        $listRunningTime = RunningTime::where('status_pembayaran', 1)
            ->get();
        foreach ($listRunningTime as $runningTime) {
            $jumlahNilaiTransaksi += $runningTime->total();
        }
        return [
            Stat::make('Jumlah Member', $jumlahMember)
                ->description('Jumlah keseluruhan member')
                ->chart($arrayJumlahMember)
                ->color('success'),
            Stat::make('Jumlah Produk', $jumlahProduk)
                ->description('Jumlah Order')
                ->color('primary')
                ->chart($arrayJumlahNilaiTransaksi),
            Stat::make('Jumlah Transaksi', $jumlahRunningTime)
                ->description('Jumlah Transaksi')
                ->chart($arrayJumlahNilaiTransaksi)
                ->color('success'),
            Stat::make('Total Transaksi ' . date('d M Y') . ' ', 'Rp.' . number_format($nowTransaksi, 0, ',', '.'))
                ->description('Penghasilan hari ini')
                ->chart($arrayJumlahNilaiTransaksi)
                ->color('primary'),
            Stat::make('Total Nilai Transaksi', 'Rp.' . number_format($jumlahNilaiTransaksi, 0, ',', '.'))
                ->description('Jumlah Transaksi')
                ->chart($arrayJumlahNilaiTransaksi)
                ->color('success'),
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 2;
    }
}
