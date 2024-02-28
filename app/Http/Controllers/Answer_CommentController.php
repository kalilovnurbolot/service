<?php

namespace App\Http\Controllers;

use App\Models\Answer_Comment;
use Illuminate\Http\Request;

class Answer_CommentController extends Controller
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
        'comment_id'=>$request['comment_id'],
        'answer'=>$request['answer'],
        'img'=>$filename,
    ]);
    return response()->json(['message'=>'Urraaa',200]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
