<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Like;
use App\Models\User;
use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    $articles = Article::all();
    $article_id = $articles->count() === 0 ? 0 : $articles->random(1)[0]->id;

    $users = User::all();
    $user_id = $users->count() === 0 ? 0 : $users->random(1)[0]->id;

    return [
        'article_id' => $article_id,
        'user_id'    => $user_id,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
