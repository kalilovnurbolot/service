<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class AuthController extends Controller

{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $roles = User::getRoles();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role'=>4,
        ]);

        // $token = $this->generateAuthToken($user); 

        // return response()->json(['token' => $token], 201);
    }
    public function __construct(){
        $this->middleware('api')->except('login');
    }
    public function login(Request $request){
        $credentials=$request->only(['email','password']);
        if (! $token=auth('api')->attempt($credentials)){
            return response()->json(['error'=>'unauthorized',401]);
        }
        return $this->responWithToken($token);
    }
    public function user(){
        $user = auth('api')->user();
        $roles = User::getRoles();
        $user['role'] = $roles[$user['role']];
        return $user;
    }
    public function logout(){}
    public function refresh(){}
    public function responWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'type'=>'Bearer',
            'expires_in'=> Config::get('jwt.ttl') * 60
        ]);
    }
    private function generateAuthToken($user)
    {
        $token = $user->id . '-' . sha1(now());

        return $token;
    }
}
