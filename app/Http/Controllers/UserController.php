<?php

namespace App\Http\Controllers;

// use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $user = User::all();

        return $user;
    }


    public function store(Request $request)
    {
        $request->user();
        $this->authorize('create', User::class);
        $request->validate([
            'nom'=>"required",
            'prenom'=>"required",
            'email'=>"required|email",
            "password"=>"required|min:7|max:20",
            "numero"=>"required",
            "role"=>"required",
        ]);

        $user = User::create([
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'email'=>$request->email,
            "password"=>Hash::make($request->password),
            "numero"=>$request->numero,
            "role"=>$request->role
        ]);

        return $user;
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 401);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success =  $user->createToken('MyApp')->plainTextToken;
            return response(['token' => $success], 200);
        }

        return response(['message' => 'Email or password is wrong'], 401);
    }
}
