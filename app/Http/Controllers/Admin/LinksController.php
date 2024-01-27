<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LinkRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function index()
    {
        $links = Link::get();
        $data = [
            'links' => $links
        ];
        return view('admin.pages.links.index')->with($data);
    }
    public function create()
    {
        return view('admin.pages.links.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkRequest $request)
    {
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/links/images','public');
        }  

    $link = new link();
    $link->title = $request->title;
    $link->subtitle = $request->subtitle; 
    $link->status = $request->status;
    $link->image = $path;
    $link->link = filled($request->link);
    $link->save();
    
    $data = [
        'status' => 'success',
        'message' => 'لینک با موفقیت ثبت شد'
        ];
    return redirect()->route('links.index')->with($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        $data = [
            'link' => $link,
        ];
        return view('admin.pages.links.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkRequest $request,Link $link)
    {
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/links/images','public');
            Storage::disk('public')->delete($link->image);
        }  
        $link->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->input('link'),
            'status' => $request->status,
            $request->filled($request->input('image')) ? $link->image : $path
        ]);
        
        $data = [
                'status' => 'success',
                'message' => 'لینک با موفقیت به روز شد'
            ];

        return redirect()->route('links.index')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        $link = Link::findOrFail($id);
        $link->delete();
        Storage::disk('public')->delete($link->image);
        $data= [
        'status' => 'success',
        'message' => 'لینک با موفقیت حذف شد',
        ];

    return redirect()->back()->with($data);
    }
}
