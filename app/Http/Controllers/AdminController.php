<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        $Admin = User::all();
        return response($Admin);
    }

    public function loginAdmin(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $token = Auth::attempt($request->only('email', 'password'));

        return response($token, 202);
    }

    public function registerAdmin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'age' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response('Admin registered', 200);
    }

    public function show($id)
    {
        if(count($admin = User::where('id', $id)->get()) > 0){
            return response($admin);
        }
        return response('There is no admin that match your searching credentiales', 401);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'age' => 'required|max:3',
            'gender' => 'required'
        ]);

        $request->user()->update([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender
            ]);

        return response('Admin stats udated', 200);
    }

    public function destroy($id, Request $request)
    {
        if($request->user()->id === $id){
            User::where('id', $id)->delete();
        }

        return response('Admin successfully deleted', 202);
    }
}
