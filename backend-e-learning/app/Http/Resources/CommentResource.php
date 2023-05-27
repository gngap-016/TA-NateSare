<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment_content' => $this->body,
            'user_comment' => $this->whenLoaded('user')->name,
            'post_comment' => $this->whenLoaded('post')->slug,
            'comment_at' => $this->created_at->diffForHumans(),
        ];
    }
}
