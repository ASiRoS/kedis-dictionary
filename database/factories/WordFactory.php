<?php

use App\User;
use App\Word;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var $factory Factory */
$factory->define(Word::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->text,
        'user_id' => \factory(User::class)->create()->id
    ];
})
    ->state(Word::class, 'published', [
        'is_published' => true
    ])
    ->state(Word::class, 'unpublished', [
        'is_published' => false
    ])
;


