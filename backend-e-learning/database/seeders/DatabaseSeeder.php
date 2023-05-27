<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'username' => 'ganuta',
            'name' => 'Gilang Aji Panutan',
            'email' => 'gilang@gmail.com',
            'password' => Hash::make('12345'),
            'level' => 'admin',
            'paid_status' => 0,
        ]);

        Post::create([
            'slug' => 'postingan-pertama',
            'excerpt' => 'Ini adalah postingan pertama',
            'title' => 'Postingan Pertama',
            'category_id' => 1,
            'image' => null,
            'body' => 'Ini adalah isi dari postingan pertama',
            'author_id' => 1,
            'status' => 'free',
            'publish' => 1,
            'published_at' => '2023-05-26',
        ]);

        Category::create([
            'slug' => 'excel',
            'name' => 'Excel'
        ]);

        Comment::create([
            'body' => 'Isi dari komentar pertama',
            'user_id' => 1,
            'post_slug' => 'postingan-pertama',
        ]);
    }
}
