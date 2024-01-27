<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
		'category_id',
        'subtitle',
        'summary',
        'body',
        'image',
        'published_at',
        'views_count',
        'slug',
        'featured',
        'status',
        'resource_url',
        'created_at',
        'updated_at',
        
    ];

    public function user(){
		return $this->belongsTo(User::class);
	}
    public function category(){
		return $this->belongsTo(Category::class);
	}
    protected $appends = [
        'image_url'
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

    public function attachTags(array $tags,$Onupdate = false)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tag =Tag::firstOrCreate([
                'name' => $tag
            ]);
            $tagIds[] = $tag->id;
            if ($Onupdate == true) {
                $this->tags()->sync($tagIds);
            }else {
                $this->tags()->attach($tag->id);
            }
        }
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'news_tag');
    }
    }

