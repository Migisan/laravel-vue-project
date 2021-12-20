<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title(),
        'body' => $faker->realText(),
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
