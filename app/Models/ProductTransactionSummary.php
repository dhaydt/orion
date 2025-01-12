<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactionSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total',
        'transaction',
    ];
}
