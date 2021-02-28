<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\post_tag;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(post_tag::class, function (Faker $faker) {
    $postIDs  = App\Models\Post::pluck('id')->all();
    $tagIDs  = App\Models\Tag::pluck('id')->all();
    return [
        'post_id' => $faker->randomElement($postIDs),
        'tag_id' => $faker->randomElement($tagIDs)
    ];
});
