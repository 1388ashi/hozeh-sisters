<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuthRequest;
use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
      public function showLoginForm()
      {
         return view("login.login");
      }
      public function login(Request $request)
      {
            $credentials = $request->validate([
                  'phone' => ['required', 'digits:11'],
                  'password' => ['required', 'min:3'],
            ]);
            $phone = $request->phone;
            $password = $request->password;
            

      $user = User::where('phone',$phone)->first();
      if(Auth::attempt($credentials)){
            if (Hash::check($password,$user->password)){
            session()->put('user_id',$user->id);
            session()->put('user_title',$user->name);
            return redirect()->route('admin-index');
            } else {
            $status = 'danger';
            $message = 'اطلاعات وارد شده اشتباه است';
            return redirect()->back()->with(['status' => $status,'message' => $message]);
            }
      }else{
      $status = 'danger';
      $message = 'اطلاعات وارد شده اشتباه است';
      $data = [
            'status' => $status,
            'message' => $message
            ];
      return redirect()->back()->with($data);
      }
      }
      public function logout(){
            Auth::logout();
            return redirect('/login');
      }
}
