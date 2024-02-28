<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
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

        $newComment=Comment::create([
            'user_id'=>$user->id,
            'post_id'=>$request['post_id'],
            'message'=>$request['message'],
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
