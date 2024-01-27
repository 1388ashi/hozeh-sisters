<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index() {
        $menuItems = MenuItem::query()
            ->select(
                ['id','title','link','order','menu_group_id'])
            ->where('status',1)
            ->with('menuGroup:id,name')
            ->ordered()
            ->get();
        return response()->success('',compact('menuItems'));
    }
}
