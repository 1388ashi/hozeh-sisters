<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::query()
            ->with('articles','posts')
            ->select(
                ['id','name'])
            ->where('status',1)
            ->get();

        return response()->success('',compact('categories'));
    }
}
