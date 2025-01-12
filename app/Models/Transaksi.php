<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaksis';
    protected $fillable = [
        'total',
        'potongan',
        'jumlah_item',
        'deskripsi',
        'status_pembayaran'
    ];

    public function transaksiProduk()
    {
        return $this->hasMany(TransaksiProduk::class, 'id_transaksi');
    }

    /**
     * Get the user that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(TransaksiProduk::class, 'id', 'id_transaksi');
    }
}
