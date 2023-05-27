<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // protected $with = ['users', 'posts'];

    // public function users(): HasMany {
    //     return $this->hasMany(User::class, 'user_id', 'id');
    // }

    // public function posts(): HasMany {
    //     return $this->hasMany(Post::class, 'post_id', 'id');
    // }
}
