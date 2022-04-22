<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\Models\Comment;
use App\Models\Article;
use App\Models\User;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'article_id' => function () {
            return factory(Article::class)->create()->id;
        },
        'comment' => $faker->text(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
