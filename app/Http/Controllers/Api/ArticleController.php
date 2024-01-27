<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;

class ArticleController extends Controller
{
    public function index() {
        $categoryId = request('category_id');

        $articles = Article::query()
            ->where('status',1)
            ->with('category:id,name')
            ->when($categoryId > 0,function(Builder $query) use($categoryId) {
                return $query->Where('category_id',$categoryId);
            })
            ->get();
            
        return response()->success('',compact('articles'));
    }
    public function show(Article $article)
    {
        return response()->success('',compact('article'));
    }
}
