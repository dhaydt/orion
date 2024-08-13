<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukLog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'produk_logs';
    protected $fillable = [
        'id_produk',
        'keterangan',
        'id_user'
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user')->withDefault();
    }
}
