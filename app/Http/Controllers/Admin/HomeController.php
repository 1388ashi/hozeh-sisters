<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use App\Models\Article;
use App\Models\Category;
use App\Models\Link;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(){
        $postsCount = Post::count();
        $articlesCount = Article::count();
        $announcementsCount = Announcements::count();
        $slidersCount = Slider::count();
        $categoryCount = Category::count();
        $linksCount = Link::count();
        return view('admin.pages.dashboard',compact(
        'postsCount'
        ,'articlesCount'
        ,'announcementsCount'
        ,'slidersCount'
        ,'categoryCount'
        ,'linksCount'));
    }
}
