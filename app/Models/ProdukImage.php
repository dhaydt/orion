<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukImage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'produk_images';
    protected $fillable = [
        'id_produk',
        'image'
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk')->withDefault();
    }
}
