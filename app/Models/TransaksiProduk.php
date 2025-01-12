<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiProduk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaksi_produks';
    protected $fillable = [
        'id_produk',
        'id_running_time',
        'harga',
        'jumlah',
        'sub_total',
        'id_transaksi',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk')->withDefault();
    }

    public function runningTime()
    {
        return $this->belongsTo(RunningTime::class, 'id_running_time')->withDefault();
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi')->withDefault();
    }
}
