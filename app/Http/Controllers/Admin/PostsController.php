<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Requests\PostRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
        public function index()
        {
            $categoryId = request("category_id") !== "all" ? request("category_id") : null;
            $status = request("status") !== "all" ? request("status") : null;
            $title = request("title");
            $startedDate = request("started_date");
            $finishedDate = request("finished_date");
            $posts = Post::select("id", "status", "title", "resource_url",'subtitle','summary', "image", "published_at", "featured", "user_id", "category_id")
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
                ->paginate(15);
            $categories = Category::select("id", "name");
            $users = User::select("id", "name", "phone")->get();
    
            return view("admin.pages.news.index", compact(["posts", "categories", "users"]));
        }
        public function create()
        {
            $categories = Category::all()->where('type','news');
            $tags = Tag::all();
            return view('admin.pages.news.create')->with([
                'categories' => $categories,
                'tags' => $tags
            ]);
        }
        
        /**
         * Store a newly created resource in storage.
         */
        public function store(PostRequest $request)
        {
            if(!empty($request->hasFile('image'))){
                $path = $request->file('image')->store('/posts/images','public');
            }  
        $category_id = category::find($request->category)->id;
        $post = new Post();
        $post->user_id = session()->get('user_id');
        $post->category_id = $category_id;
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->summary = $request->summary; 
        $post->body = $request->body;
        $post->slug = Str::slug($request->slug);
        $post->published_at = $request->input('published_at');
        $post->status = $request->input('status');
        $post->featured = $request->input('featured');
        $post->image = $path;
        $post->resource_url = $request->input('resource_url');
        $post->save();
        $tags = $request->input('tags');
        $post->attachTags($tags);
    
        $data = [
            'status' => 'success',
            'message' => 'خبر با موفقیت ثبت شد'
        ];
        return redirect()->route('posts.index')->with($data);
    }
/**
 * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        return view('admin.pages.news.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(post $post)
    {
        $categories = Category::where('type','news')->get();  
        $tags = Tag::get();  
        $tagids = $post->tags()->pluck('tags.id')->toArray();
        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'tag_ids' => $tagids
        ];
        return view('admin.pages.news.edit')->with($data);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request,Post $post)
    {
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/posts/images','public');
            Storage::disk('public')->delete($post->image);
        }  
        $tags = $request->input('tags');
        $post->attachTags($tags,true);

        $post->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'summary' => $request->summary,
            'body' => $request->body,
            'status' => $request->status,
            'featured' => $request->featured,
            'slug' => Str::slug($request->slug),
            'resource_url' => $request->resource_url,
            'categorey_id' => $request->categorey,
            'image' => $path
        ]);
        
        $data = [
                'status' => 'success',
                'message' => 'داده ها با موفقیت به روز شد'
            ];

            return redirect()->route('posts.index')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        $post = Post::findOrFail($id);
        $post->delete();
        Storage::disk('public')->delete($post->image);
        $data = [
        'status' => 'success',
        'message' => 'خبر با موفقیت حذف شد',
        ];

    return redirect()->back()->with($data);
    }

}
