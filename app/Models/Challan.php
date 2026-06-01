<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challan extends Model
{
    use HasFactory;

    protected $fillable = [
        'challan_id',
        'case_id',
        'prahari_id',
        'amount',
        'status',
    ];

    public function prahari()
    {
        return $this->belongsTo(Prahari::class);
    }

    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}