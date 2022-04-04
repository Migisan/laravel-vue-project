<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Article::class, function (Faker $faker) {
    $users = User::all();
    $user_id = $users->count() === 0 ? 0 : $users->random(1)[0]->id;

    return [
        'title' => $faker->word(),
        'body' => $faker->text(),
        'user_id' => $user_id,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
