<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // register (as user/normal registeration)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 0;
        $user->save();

        return redirect()->back()->with(['message' => 'Registration Successfull']);
    }


    // login (for all users)
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $credentials = $request->only(['email', 'password']);

        if(Auth::attempt($credentials))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return redirect()->back()->with(['message' => 'Invalid Credentials'])->withInput();
        }
    }


    // logout
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
