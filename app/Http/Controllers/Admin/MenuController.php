<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Models\MenuGroup;
use App\Models\MenuItem;
use Validator;

class MenuController extends Controller
{
        public function groups():Renderable
        {
            $menuGroups = MenuGroup::all();
            return view('admin.pages.menu.group', compact('menuGroups'));
        }
    
        public function sortMenus(Request $request)
        {
            MenuItem::setNewOrder($request->menus);
            return redirect()->back();
        }
    
        public function index()
        {
            $menuGroup = MenuGroup::query()->findOrFail(request('menu_group_id'));
            $menuItems = $menuGroup->menuItems()->ordered()->get();
            $models = MenuItem::MODELS;
            $categories = MenuItem::AllCategories();
            return view('admin.pages.menu.index', compact('menuItems', 'menuGroup', 'models', 'categories'));
        }
    
    
        public function create()
        {
            $models = MenuItem::MODELS;
            $categories = MenuItem::getAllCategories();
            return view('admin.menu.create',compact(['models','categories']));
        }
    
        public function store(MenuRequest $request)
        {
            $items = new MenuItem();
            $items->title = $request->input('title');
            $items->linkable_type = $request->input('linkable_type');
            $items->linkable_id = $request->input('linkable_id');
            $items->link = $request->input('link');
            $items->menu_group_id = request('menu_group_id');
            $items->new_tab = $request->input('new_tab');
            $items->status = $request->input('status');
            $items->save();
            return redirect()->back();
        }
    
        public function show(string $id)
        {
            //
        }
    
        public function edit(string $id)
        {
            //
        }
    
    public function update(Request $request, string $menuItemId)
    {
            $rules=[
                'linkable_id' => 'required_without:link',
                'link' => [
                    'required_without:linkable_id',
                    'nullable',
                    'url',
                ]
            ];
    
            $menu = MenuItem::find($menuItemId);
            $menu->update([
                'linkable_type'=>$request->linkable_type,
                'linkable_id'=>$request->linkable_id,
                'title'=>$request->title,
                'link'=>$request->link,
                'new_tab'=>$request->new_tab,
                'status'=>$request->status
    
            ]);
            $validator= Validator::make($request->all(),$rules);
            if ($validator->fails()){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $id = $request->item_id;
        MenuItem::findOrFail($id)->delete();
        $data = [
        'status' => 'success',
        'message' => 'ایتم با موفقیت حذف شد',
        ];

    return redirect()->back()->with($data);
    }
}
