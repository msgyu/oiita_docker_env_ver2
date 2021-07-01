<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    $postIDs  = App\Models\Post::pluck('id')->all();
    $userIDs  = App\User::pluck('id')->all();
    return [
        'post_id' => $faker->randomElement($postIDs),
        'user_id' => $faker->randomElement($userIDs),
    ];
});
