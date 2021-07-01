<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PostTag;
use App\Models\Post;
use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(PostTag::class, function (Faker $faker) {
    $postIDs  = Post::pluck('id')->all();
    $tagIDs  = Tag::pluck('id')->all();
    return [
        'post_id' => $faker->randomElement($postIDs),
        'tag_id' => $faker->randomElement($tagIDs)
    ];
});
