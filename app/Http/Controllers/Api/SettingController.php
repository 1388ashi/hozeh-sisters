<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {
        $settingTypesSocial = Setting::query()->where('group','social')->get()->groupBy('type'); 
        $settingTypesGeneral = Setting::query()->where('group','general')->get()->groupBy('type'); 
        $group = Setting::GROUP['social'];
        return response()->success('',compact('settingTypesSocial','group','settingTypesGeneral'));
    }
}
