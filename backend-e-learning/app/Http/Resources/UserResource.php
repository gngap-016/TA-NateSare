<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'user_username' => $this->username,
            'user_name' => $this->name,
            'user_image' => $this->image,
            'user_email' => $this->email,
            'user_level' => $this->level,
            'user_paid_status' => $this->paid_status,
            'user_api_token' => $this->api_token,
        ];
    }
}
