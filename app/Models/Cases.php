<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document ? Storage::disk('public')->url($this->document) : null;
    }

    public function getDocumentIsImageAttribute(): bool
    {
        return $this->document && Str::startsWith(Storage::disk('public')->mimeType($this->document) ?? '', 'image/');
    }

    public function getDocumentIsVideoAttribute(): bool
    {
        return $this->document && Str::startsWith(Storage::disk('public')->mimeType($this->document) ?? '', 'video/');
    }
}
