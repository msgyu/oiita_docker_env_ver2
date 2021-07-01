<?php

use Illuminate\Database\Seeder;
use App\Models\post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = App\Models\Tag::all();
        factory(post::class, 200)
            ->create()
            ->each(function ($post) use ($tags) {
                $post->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
                $post->likes_count()->create();
            });
    }
}
