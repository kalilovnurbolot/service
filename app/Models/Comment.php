<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public function post(){
        $this->belongsTo(Post::class);
    }
    public function answer_comment(){
      return  $this->hasMany(Answer_Comment::class);
    }
    protected $fillable=[
        'post_id',
        'message',
        'img',
        'user_id',
    ];
}
