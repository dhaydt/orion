<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'produks';
    protected $fillable = [
        'nama',
        'stock',
        'harga',
        'deskripsi'
    ];

    public function produkLog()
    {
        return $this->hasMany(ProdukLog::class, 'id_produk');
    }

    public function produkImage()
    {
        return $this->hasMany(ProdukImage::class, 'id_produk');
    }

    public function transaksiProduk()
    {
        return $this->hasMany(TransaksiProduk::class, 'id_produk');
    }

    public function updateStock($action = 1, $stock){
        if($action == 1){
            $this->stock += $stock;
        }else{
            if($this->stock < $stock || $this->stock == 0){
                return false;
            }
            $this->stock -= $stock;
        }
        $this->save();
        return true;
    }
}
