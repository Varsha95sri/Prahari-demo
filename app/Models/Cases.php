<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'prahari_id',
        'type',
        'location',
        'description',
        'document',
        'status',
    ];

    public function prahari()
    {
        return $this->belongsTo(Prahari::class);
    }

    public function challans()
    {
        return $this->hasMany(Challan::class, 'case_id');
    }
}