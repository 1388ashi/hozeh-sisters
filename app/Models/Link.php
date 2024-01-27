<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'link',
        'image',
        'status',
        'created_at',
        'updated_at',
        
    ];
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImage()
        );
    }
    public function getImage(): string
    {
        return Storage::disk('public')->url($this->attributes['image']);
    }
}
