<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(){
        $user_id = session()->get('user_id');
        $user = User::where('id',$user_id)->first();
        return view('admin.pages.profile.edit')->with(['user' => $user]);
    }
    public function update(User $user,ProfileRequest $request){

        $user->update([
            'name' => $request->name,
            'email' => $request->input('email'),
            'phone' => $request->phone,
        ]);

        $data = [
            'status' => 'success',
            'message' => 'کاربر با موفقیت به روز شد',
        ];
        return redirect()->back()->with($data);
    }
  

}
