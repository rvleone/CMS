<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function index(){
      return view('admin.register');
    }

    public function register(Request $request){
        $data = $request->only(['name', 'email', 'password', 'password_confirmation']);
        $validated = $this->validator($data);
        if($validated->fails()){
            return redirect()->route('register')->withErrors($validated)->withInput();

        }else{
             //register user in database
         $data['password'] = Hash::make($data['password']);
         $user = User::create($data);
         Auth::login($user);
         $user->createToken('Login_token')->plainTextToken;
        return redirect()->route('admin');
        }

    }

    public function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|min:3|string',
            'email' => 'required|email|unique:users',
            'password' =>'required|min:6|string|confirmed',
        ]);
    }
}
