<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $data = [
            'sliders' => $sliders
        ];
        return view('admin.pages.sliders.index')->with($data);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.sliders.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/sliders/images','public');
        }  
    $slider = new slider();
    $slider->title = $request->title;
    $slider->summary = $request->summary; 
    $slider->status =  $request->status;
    $slider->image = $path;
    $slider->link = $request->link;
    $slider->save();
    
    $data = [
        'status' => 'success',
        'message' => 'اسلایدر با موفقیت ثبت شد'
        ];
    return redirect()->route('sliders.index')->with($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.pages.sliders.show', ['slider' => $slider]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $data = [
            'slider' => $slider,
        ];
        return view('admin.pages.sliders.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Slider $slider)
    {
        if(!empty($request->hasFile('image'))){
            $path = $request->file('image')->store('/sliders/images','public');
            Storage::disk('public')->delete($slider->image);
        }  
        $slider->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'link' => $request->link,
            'status' => $request->status,
            'image' =>  $path
        ]);
        
        $data = [
                'status' => 'success',
                'message' => 'اسلایدر با موفقیت به روز شد'
            ];

        return redirect()->route('sliders.index')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        $slider = Slider::findOrFail($id);
        $slider->delete();
        Storage::disk('public')->delete($slider->image);
        $data= [
        'status' => 'success',
        'message' => 'اسلایدر با موفقیت حذف شد',
        ];
        
        return redirect()->back()->with($data);
    }
}
