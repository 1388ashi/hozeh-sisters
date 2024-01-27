<?php

namespace App\Http\Controllers\Admin;

use Validator;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        $data = [
            'tags' => $tags
        ];
        return view('admin.pages.tags.index',$data);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $data = [
            'tags' => $tags
        ];
        return view('admin.pages.tags.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->name; 

        $rules= [
            'name' =>'required | min:5',
        ];
    
        $messages = [
            'name.required' => "فیلد عنوان الزامی است",
            'name.min' => "عنوان  حداقل 5 کاراکتر باید باشد",
        ];

        $data = [
            'status' => 'success',
            'message' => 'برچسب با موفقیت ثبت شد'
        ];

        $validator = Validator::make($request->all(),$rules,$messages);

        $insert = DB::table('tags')->insert(
        ['name' => $name]
        );

        return redirect()->route('tags.index')->with($data);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.pages.tags.edit',['tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Tag $tag,Request $request)
    {
        $rules= [
            'name' =>'required',
        ];
        $messages = [
            'name.required' => "فیلد عنوان الزامی است",
        ];
    
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
    $tag->update([
      'name' => $request->name,
    ]);
    $data = [
           'status' => 'success',
           'message' => 'برچسب با موفقیت به روز شد'
    ];
    
    return redirect()->route('tags.index')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        Tag::find($id)->delete();
        $data= [
        'status' => 'success',
        'message' => 'برچسب با موفقیت حذف شد',
        ];

    return redirect()->back()->with($data);
    }
}
