<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentUser as CommentUserResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'content'=> $this->content,
            'created'=> (string)$this->created_at,
            'updated'=> (string)$this->updated_at,
            'user' => new CommentUserResource($this->whenLoaded('user'))
        ];
    }
}
