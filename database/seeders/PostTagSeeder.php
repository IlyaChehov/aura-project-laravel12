<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();
        $posts = Post::all();

        foreach ($posts as $post) {
            $tagsIds = $tags->random(random_int(0, count($tags)))->pluck('id');
            $post->tags()->syncWithoutDetaching($tagsIds);
        }
    }
}
