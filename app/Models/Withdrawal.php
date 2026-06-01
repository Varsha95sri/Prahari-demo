<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'prahari_id',
        'amount',
        'bank_account',
        'ifsc',
        'status',
    ];

    public function prahari()
    {
        return $this->belongsTo(Prahari::class);
    }
}