<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
       
        // Проверяем, что пользователь аутентифицирован
        if ($user&&$user->role=='admin') {
            return User::all();
           
           
        } elseif($user&&$user->role=='user') {
            $user_id=$user->id;
            $roles = User::getRoles();
            $user = User::find($user_id);
            $user['role'] = $roles[$user['role']];
            echo $roles[$user['role']];
            $newUser = array(
                "id" => $user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "email_verified_at" => $user['email_verified_at'],
                "created_at"  => $user['created_at'],
                "updated_at" => $user['updated_at'],
                "role" => 123213
            );
            return $newUser;
        }
        else{
            return response()->json(['error','вы не авторизованы']);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $roles = User::getRoles();
        $newUser = array(
            "id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "email_verified_at" => $user['email_verified_at'],
            "created_at"  => $user['created_at'],
            "updated_at" => $user['updated_at'],
            "role" => $roles($user['role'])
        );
        return $newUser;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentuser = Auth::user();
       
        // Проверяем, что пользователь аутентифицирован
        if ($currentuser&&$currentuser->role==1) {
           
            $user->update($request->all());
        return response()->json($user);
           
        } elseif($currentuser&&$currentuser->role==2) {
            return response()->json(['error','у вас нету права доступа для обновление ']);
           
            
        }
        else{
            return response()->json(['error','вы не авторизованы']);
        }

    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $Currentuser = Auth::user();
       
        // Проверяем, что пользователь аутентифицирован
        if ($Currentuser&&$Currentuser->role=='admin') {
            $user->delete();
           return response(null,);
           
        } elseif($Currentuser&&$Currentuser->role=='user') {
           return response()->json(['error',' у вас нету права доступа к удалению']);
        }
        else{
            return response()->json(['error','вы не авторизованы']);
        }
    }
}
