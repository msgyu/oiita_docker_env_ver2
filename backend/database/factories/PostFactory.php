<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\post;
use App\Models\tag;
use Faker\Generator as Faker;

$factory->define(post::class, function (Faker $faker) {
    $userIDs  = App\User::pluck('id')->all();
    $tagIDs  = App\Models\tag::pluck('id')->all();
    return [
        'title'     => $faker->realText(30),
        'body'      => $faker->realText(),
        'user_id'   => $faker->randomElement($userIDs),
    ];
});
