<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\User;
use Str;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ArticleController extends Controller
{
    public function index()
    {
        $categoryId = request("category_id") !== "all" ? request("category_id") : null;
        $status = request("status") !== "all" ? request("status") : null;
        $title = request("title");
        $startedDate = request("started_date");
        $finishedDate = request("finished_date");
        $articles = Article::select("id", "status", "title",'views_count','summary', "image", "user_id", "category_id")
            ->when($title, function (Builder $query) use ($title) {
                return $query->where("title", "like", "%{$title}%");
            })
            ->when($startedDate, function (Builder $query) use ($startedDate) {
                return $query->where("published_at", ">=", $startedDate);
            })
            ->when($finishedDate, function (Builder $query) use ($finishedDate) {
                return $query->where("published_at", "<=", $finishedDate);
            })
            ->when($categoryId, function (Builder $query) use ($categoryId) {
                return $query->where("category_id", $categoryId);
            })
            ->when(isset($status), function (Builder $query) use ($status) {
                return $query->where("status", $status);
            })
            ->get();
        $categories = Category::select("id", "name");
        $users = User::select("id", "name", "phone")->get();

        return view("admin.pages.articles.index", compact(["articles", "categories", "users"]));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type','article')->get();
        $data = [
            'categories' => $categories
        ];
        return view('admin.pages.articles.create')->with($data);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $data = [
            'status' => 'success',
            'message' => 'آموزش با موفقیت ثبت شد'
            ];

        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/articles/images','public');
        }  

    $category_id = category::find($request->category)->id;
    $article = new Article();
    $article->user_id = session()->get('user_id');
    $article->category_id = $category_id;
    $article->title = $request->title;
    $article->slug = Str::slug($request->slug);
    $article->summary = $request->summary; 
    $article->body = $request->body;
    $article->status = $request->input('status');
    $article->image = $path;
    $article->resource = $request->input('resource');
    $article->save();

    return redirect()->route('articles.index')->with($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.pages.articles.show', ['article' => $article]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::where('type','article')->get();  
        $data = [
            'article' => $article,
            'categories' => $categories,
        ];
        return view('admin.pages.articles.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/posts/images','public');
            Storage::disk('public')->delete($article->image);
        }  
        $article->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'body' => $request->body,
            'status' => $request->status,
            'resource' => $request->resource,
            'categorey_id' => $request->categorey,
            $request->filled($request->input('image')) ? $article->image : $path
        ]);
        
        $data = [
                'status' => 'success',
                'message' => 'آموزش با موفقیت به روز شد'
            ];

        return redirect()->route('articles.index')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        $article = Article::findOrFail($id);
        $article->delete();
        Storage::disk('public')->delete($article->image);
        $data= [
        'status' => 'success',
        'message' => 'آموزش با موفقیت حذف شد',
        ];
    return redirect()->back()->with($data);
    }
    public function search(Request $request){

        $user=$request->user_id;
        $title = $request->title;
        $s_date =$request->s_date;
        $e_date=$request->e_date;
        $status = $request->status;


        $articles= Article::query()

            ->when($user=='all',function ($qurey) use($user)
            {
                return $qurey;
            })
            ->when($user!='all',function ($query) use ($user)
            {
                $query->where('user_id',$user);

            })
            ->when($title,function ($query) use ($title)
            {
                $query->where('title','like','%'.$title.'%');

            })
            ->when($status=='all',function ($query) use ($status)
            {
                return $query;
            })
            ->when($status!='all',function ($query) use ($status)
            {
                return  $query->where('status',$status);
            })->get();

        return view('admin.pages.articles.filter',compact('articles'));
    }
}
