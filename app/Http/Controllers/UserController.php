<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // user list
    public function list()
    {
        $users = User::where('role', 0)->latest()->get();

        // return view('admin.user-list', [
        //     'users' => $users
        // ]);

        return view('admin.user-list', compact('users'));
    }


    // register users (as an admin)
    public function addUser(Request $request)
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

        return redirect()->back()->with(['message' => 'User added successfully']);
    }
}
