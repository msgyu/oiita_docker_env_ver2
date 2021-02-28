<?php

use Illuminate\Database\Seeder;
use App\Models\Like;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Like::class, 500)->create();
        $posts = App\Models\Post::all();
        $users = App\User::pluck('id')->all();
        $posts->each(function ($post) use ($users) {
            for ($count = 0; $count < rand(10, 1000); $count++) {
                $post->likes()->create([
                    'user_id' => $users[array_rand($users)],
                ]);
                $likes_count = $post->likes_count;
                $likes_count->update(['likes_count' => ++$likes_count->likes_count]);
            }
        });
    }
}
