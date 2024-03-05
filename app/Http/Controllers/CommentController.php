<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        $comments = Comment::all();
    
        $commentData = [];
    
        foreach ($comments as $comment) {
            $totalLikes = Like::where('comment_id', $comment->id)->where('like', 1)->count();
            $commentResource=new CommentResource($comment);
            $commentData[] = [
                'question' => $commentResource,
                'total_likes' => $totalLikes
            ];
        }
    
        return response()->json($commentData);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['message' => 'Вы не авторизованы'], 401);
        }
    
        $filename = null;
    
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('uploads/img/' . $filename); // Добавляем косую черту перед $filename
            $img->move(public_path('uploads/img'), $filename);
        }
    
        $newComment = Comment::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'post_id' => $request['post_id'],
            'message' => $request['message'],
            'img' => $filename,
        ]);
    
        return response()->json($newComment, 200);
    }
    

    /**
     * Display the specified resource.
     */
    

public function show(Comment $comment)
{
    $comment->increment('views');

    $totalLikes = Like::where('comment_id', $comment->id)
        ->where('like', 1)
        ->count();
$commentResource=new CommentResource($comment);
    return response()->json([
        'question' => $commentResource,
        'total_likes' => $totalLikes
    ]);
}



       public function popular(){
        $popularComments = Comment::orderBy('likes_count', 'desc')
        ->take(10) 
        ->get();
        return $popularComments;
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
