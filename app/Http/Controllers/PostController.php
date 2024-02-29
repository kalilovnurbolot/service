<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Current user:', ['user' => auth()->user()]);
        $user = auth('api')->user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|',
        ]);
        // Проверяем, что пользователь аутентифицирован
        if (!$user) {
            return response()->json([ 'message'=>'вы не авторизованы',401]);
        }
            // Создаем новый пост

          
            
      
        $post = new Post();
        $post->name = $validatedData['name']; // Ваша логика для названия поста
        $post->user_id = $user->id; // Устанавливаем id пользователя в поле user_id
        $post->save();

        return response()->json($post, 201);
        }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post->load('comment');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
