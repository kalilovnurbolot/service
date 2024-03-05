<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return[
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'name'=>$this->name,
            'post_id'=>$this->post_id,
            'message'=>$this->message,
            'img'=>$this->img,
            'views'=>$this->views

        ];
    }
}
