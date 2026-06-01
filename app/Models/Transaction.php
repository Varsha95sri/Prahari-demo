<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'prahari_id',
        'challan_id',
        'type',
        'amount',
        'description',
    ];

    public function prahari()
    {
        return $this->belongsTo(Prahari::class);
    }

    public function challan()
    {
        return $this->belongsTo(Challan::class);
    }
}