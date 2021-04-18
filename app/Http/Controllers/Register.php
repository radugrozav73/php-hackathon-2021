<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class Register extends Controller
{
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'numericalcode' => 'required|string|min:13|max:13'
        ]);

        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'numericalcode' => $request->numericalcode,
            'password'=>Hash::make($request->password),
        ]);

        $token = Auth::attempt($request->only('email', 'password'));
        return response($token);
    }
}
