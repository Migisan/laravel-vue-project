<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\Models\Article;
use App\Models\User;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'body' => $faker->text(),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
