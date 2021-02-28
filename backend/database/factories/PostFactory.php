<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $userIDs  = App\User::pluck('id')->all();
    $tagIDs  = App\Models\Tag::pluck('id')->all();
    return [
        'title'     => $faker->realText(30),
        'body'      => $faker->realText(),
        'user_id'   => $faker->randomElement($userIDs),
    ];
});
