<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Like;
use App\Models\Article;
use App\Models\User;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'article_id' => function () {
            return factory(Article::class)->create()->id;
        },
        'user_id'    => function () {
            return factory(User::class)->create()->id;
        },
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
