<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunningTime extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'running_times';
    protected $fillable = [
        'waktu_mulai',
        'waktu_selesai',
        'nama_penyewa',
        'deskripsi',
        'nomor_meja',
        'id_user',
        'id_member',
        'waktu_running',
        'harga_per_jam',
        'status_pembayaran',
        'paket',
        'shift',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user')->withDefault();
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member')->withDefault();
    }

    public function transaksiProduk()
    {
        return $this->hasMany(TransaksiProduk::class, 'id_running_time');
    }

    public function total(){
        $hargaPerMenit = $this->harga_per_jam / 60;
        // dd($this->waktu_running);
        $hargaMain = $this->waktu_running * $hargaPerMenit;

        $hargaBelanja = TransaksiProduk::where('id_running_time', $this->id)->sum('sub_total');
        return $hargaMain + $hargaBelanja;
    }
}
