<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentuser = auth()->user();
        if (!$currentuser) {
            return response()->json(['message' => 'вы не авторизованы']);
        }
    
        $validated = $request->validate([
            'comment_id' => 'required|integer',
        ]);
    
        $commentLike = Like::where('user_id', $currentuser->id)
            ->where('comment_id', $validated['comment_id'])
            ->first();
    
        if ($commentLike) {
            if ($commentLike->like == 1) {
                $commentLike->update(['like' => 0]);
                return response()->json('unlike');
            } else {
                $commentLike->update(['like' => 1]);
                return response()->json('like');
            }
        } else {
            // Создаем новый лайк
            $commentLike = Like::create([
                'user_id' => $currentuser->id,
                'comment_id' => $validated['comment_id'],
                'like' => 1,
            ]);
            return response()->json('like');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
