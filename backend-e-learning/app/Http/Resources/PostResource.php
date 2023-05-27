<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'post_slug' => $this->slug,
            'post_excerpt' => $this->excerpt,
            'post_title' => $this->title,
            'post_category' => $this->whenLoaded('category')->name,
            'post_image' => $this->image,
            'post_content' => $this->body,
            'post_author' => $this->whenLoaded('author')->name,
            'post_total_comments' => count($this->whenLoaded('comments')),
            'post_comments' => $this->whenLoaded('comments', function () {
                return collect($this->comments)->each(function ($comment) {
                    return $comment;
                });
            }),
            'post_status' => $this->status,
            'post_publish' => $this->publish,
            'post_published_at' => \Carbon\Carbon::parse($this->published_at)->diffForHumans(),
        ];
    }
}
