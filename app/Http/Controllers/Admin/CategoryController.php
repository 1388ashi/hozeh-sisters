<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Requests\CategoryRequest;
use DB;
use Validator;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.pages.category.index',compact('categories'));
        
    }

    public function create()
    {
    return view('admin.pages.category.index');
    }

    public function store(CategoryRequest $request)
    {
        $insert = DB::table('categories')->insert(
            ['name' => $request->name,'slug' => Str::slug($request->slug),'type' => $request->type,'status' => $request->status]
        );
        
        $data = [
            'status' => 'success',
            'message' => 'دسته بندی  با موفقیت ثبت شد'
        ];
        return redirect()->route('categories.index')->with($data);
    }


    public function edit(category $category)
    {
        return view('admin.pages.category.edit',['category' => $category]);
    }

    public function update(category $category,CategoryRequest $request)
    {
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'status' => $request->status,
            'type' => $request->type,
        ]);
        $data = [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت به روز شد'
        ];

        return redirect()->route('categories.index')->with($data);
    } 
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        Category::findOrFail($id)->delete();
        $data= [
            'status' => 'success',
            'message' => 'دسته بندی با موفقیت حذف شد',
        ];
    
        return redirect()->back()->with($data);
    }
}
