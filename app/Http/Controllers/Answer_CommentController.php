<?php

namespace App\Http\Controllers;

use App\Models\Answer_Comment;
use App\Models\Comment;
use Illuminate\Http\Request;

class Answer_CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            // Получить комментарии, которые не связаны с таблицей answer_comment
            $comments = Comment::whereNotIn('id', Answer_Comment::pluck('comment_id'))->get();
            
            return $comments;
        }
    
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        if(!$user){
            return response()->json(['message'=>'вы не авторизованы',401]);

        }

        if($request->hasFile('img')){
            $img=$request->file('img');
            $filename=time().'.'.$img->getClientOriginalExtension();
            $path=public_path('uploads/img'.$filename);
            $img->move(public_path('upload/img'),$filename);
        }
        else{
            $filename=null;
        }

    $newComment=Answer_Comment::create([
        'user_id'=>$user->id,
        'name'=>$user->name,
        'comment_id'=>$request['comment_id'],
        'answer'=>$request['answer'],
        'img'=>$filename,
    ]);
    return response()->json($newComment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $answer_Comment=Answer_Comment::find($id);
        return $answer_Comment;
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
