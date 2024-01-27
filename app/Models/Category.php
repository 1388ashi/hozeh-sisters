<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
	use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'type',
		'created_at',
        'updated_at',
        'slug',
        
    ];
    public function posts(){
		return $this->hasMany(Post::class);
    }
    public function articles(){
		return $this->hasMany(Article::class);
    }
    public function sliders(){
		return $this->hasMany(Slider::class);
    }
    
    protected static function boot() {
      parent::boot();
  
      static::saved(function($category) {
          $category->posts()->update(['category_id' => $category->id]);
      });

      static::deleting(function($category) {
          $category->posts()->delete();
      });
}
}


