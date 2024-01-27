<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index() {
        $sliders = Slider::query()
            ->where('status',1)
            ->get();
        return response()->success('',compact('sliders'));
    }
}
