<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index() {
        $links = Link::query()
            ->where('status',1)
            ->get();
        return response()->success('',compact('links'));
    }
}
