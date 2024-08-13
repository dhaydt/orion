<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'members';
    protected $fillable = [
        'nama',
        'alamat',
        'no_hp'
    ];

    public function runningTime()
    {
        return $this->hasMany(RunningTime::class, 'id_member');
    }
}
