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
            'comment_slug' => $this->slug,
            'comment_content' => $this->body,
            'commentator' => $this->whenLoaded('users')->name,
            'post_comment' => $this->whenLoaded('posts')->slug,
            'comment_at' => $this->created_at->diffForHumans(),
        ];
    }
}
