<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $data = $request->only('email','password');
        $validated = $this->validator($data);
        $remember = $request->input('remember', false);
        if($validated->fails()){
            return redirect()->route('login')->withErrors($validated)->withInput();
        }
        if(Auth::attempt($data, $remember)){
            $user = Auth::user();
            $user = User::find($user->id);
            $user->createToken('Login_token')->plainTextToken;
            return redirect()->route('admin')->with('success','');
        }else{
            $validated->errors()->add('password','Usuário ou senha inválido');
            return redirect()->route('login')
            ->withErrors($validated)
            ->withInput();
        }
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect(route('login'));
    }

    public function validator(array $data){
        return Validator::make($data, [
            'email'=> 'required|email|string|max:255',
            'password'=> 'required|string|min:6',
        ]);
    }

}
