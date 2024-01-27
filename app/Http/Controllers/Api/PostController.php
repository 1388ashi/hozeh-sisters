<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function index() {
        $categoryId = request('category_id');
        $search = request('search');
        $tagId = request('tag_id');

        $posts = Post::query()
            ->where('status',1)
            ->with('category:id,name')
            ->whereDate('published_at','<=',now())
            ->when($categoryId > 0,function(Builder $query) use($categoryId) {
                return $query->Where('category_id',$categoryId);
            })
            ->when($search > 0,function(Builder $query) use($search) {
                return $query->Where('title','like',"%{$search}%");
            })
            ->when($tagId > 0,function(Builder $query) use($tagId) {
                return $query->with(['tags' => function(Builder $query) use($tagId){
                    $query->where('tags.id',$tagId);
                }]);
            })
            ->paginate();
            
        return response()->success('',compact('posts'));
    }
    
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->load('tags:id,name');
        return response()->success('',compact('post'));
    }
}
