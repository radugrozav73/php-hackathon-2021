<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Programmes;
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

        return response($token);
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

        return response('Done');
    }

    

    public function show($id)
    {
        if($admin = User::where('id', $id)->get()){
            return response($admin);
        }
        return response('There is no admin that match your search credentiales');
    }

    public function update(Request $request, $id)
    {
        $post = User::where('id', $id);

        if(!$post){
            return response('There is no admin that match your search credentiales');
        }

        $post->update([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender
            ]);

        return response('updated');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
    }
}
