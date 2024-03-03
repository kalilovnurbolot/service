<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer_Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'comment_id',
        'answer',
        'img',
        'user_id',
        'name',
    ];

    public function comment(){
     return   $this->belongsTo(Comment::class);
    }
}
