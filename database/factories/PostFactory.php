<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'title' => $title,
        'content' => $faker->text(1000),
        'slug' => Str::slug($title),
    ];
});
