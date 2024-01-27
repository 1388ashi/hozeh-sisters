<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementsRequest;
use App\Models\Announcements;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $categoryId = request("category_id") !== "all" ? request("category_id") : null;
        $status = request("status") !== "all" ? request("status") : null;
        $title = request("title");
        $Announcements = Announcements::select("id", "status", "title",'views_count','summary', "image", "user_id",'created_at')
            ->when($title, function (Builder $query) use ($title) {
                return $query->where("title", "like", "%{$title}%");
            })
            ->when(isset($status), function (Builder $query) use ($status) {
                return $query->where("status", $status);
            })
            ->paginate(15);
        $users = User::select("id", "name", "phone")->get();

        return view("admin.pages.announcements.index", compact(["Announcements", "users"]));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.Announcements.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementsRequest $request)
    {
        $data = [
            'status' => 'success',
            'message' => 'اطلاعیه با موفقیت ثبت شد'
            ];
            
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/announcements/images','public');
        }   
    $announcements = new Announcements();
    $announcements->user_id = session()->get('user_id');
    $announcements->title = $request->title;
    $announcements->summary = $request->summary; 
    $announcements->body = $request->body;
    $announcements->published_at = $request->input('published_at');
    $announcements->status = $request->status;
    $announcements->image = $path;
    $announcements->slug =  Str::slug($request->slug);
    $announcements->save();
    
    return redirect()->route('announcements.index')->with($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $announcements = Announcements::findOrFail($id);
        return view('admin.pages.announcements.show',compact('announcements'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $announcements = Announcements::findOrFail($id);
        return view('admin.pages.announcements.edit',compact('announcements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,AnnouncementsRequest $request)
    {
        $announcement = Announcements::findOrFail($id);
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/announcements/images','public');
            Storage::disk('public')->delete($announcement->image);
        }  

        $announcement->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'body' => $request->body,
            'status' => $request->input('status'),
            'image' => $path,
            'slug' =>  Str::slug($request->slug),
        ]);
        $data = [
                'status' => 'success',
                'message' => 'اطلاعیه با موفقیت به روز شد'
            ];

        return redirect()->route('announcements.index')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        $announcement = Announcements::findOrFail($id);
        $announcement->delete();

        Storage::disk('public')->delete($announcement->image);
        $data= [
        'status' => 'success',
        'message' => 'اطلاعیه با موفقیت حذف شد',
        ];
    return redirect()->back()->with($data);
    }
}
