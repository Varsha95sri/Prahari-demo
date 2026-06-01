<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'prahari_id',
        'balance',
    ];

    public function prahari()
    {
        return $this->belongsTo(Prahari::class);
    }
}