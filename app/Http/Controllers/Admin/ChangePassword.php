<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChangePassRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ChangePassword extends Controller
{
    public function ChangePassword(ChangePassRequest $request,User $user){
        
        if (!Hash::check($request->current_password, $user->password)) {
            $data = [
                'status' => 'danger',
                'message' => 'کلمه عبور فعلی اشتباه است.',
                ];
            return back()->with($data);
        }
            $user->password = Hash::make($request->new_password);
            $user->save();
            $request->user()->logout();
            $data = [
            'status' => 'success',
            'message' => 'کلمه عبور با موفقیت به روزسانی شد',
            ];
            return redirect()->route('login');
    }
}
