<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'group',
        'label',
        'type',
        'value',
    ];
    const GROUP = [
        'social' => 'social',
        'general' => 'general',
    ];
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getImage()
        );
    }
    public function getImage(): string
    {
        return Storage::disk('public')->url($this->attributes['profile']);
    }
}
