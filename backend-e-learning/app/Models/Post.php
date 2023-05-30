<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $with = ['author', 'comments:id,user_id,post_slug,body,created_at', 'category'];

    public function getRouteKeyName(): string {
        return 'slug';
    }

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'post_slug', 'slug');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'post_title'
            ]
        ];
    }
}
