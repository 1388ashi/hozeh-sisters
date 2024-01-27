<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use Illuminate\Http\Request;

class announcementController extends Controller
{
    public function index() {
        $announcements = Announcements::query()
            ->where('status',1)
            ->get();
            
        return response()->success('',compact('announcements'));
    }
    public function show($id)
    {
        $announcements = Announcements::query()->findOrFail($id);
        return response()->success('',compact('announcements'));
    }
}
