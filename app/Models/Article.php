<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
		'category_id',
		'slug',
        'summary',
        'body',
        'resource',
        'image',
        'views_count',
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
    public function user(){
		return $this->belongsTo(User::class);
	}
    public function category(){
		return $this->belongsTo(Category::class);
	}
}
