<?php

use Faker\Generator as Faker;

$factory->define(App\Posts::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => \Faker\Provider\Lorem::sentence($nbWords = 6, $variableNbWords = true),
        'content' => \Faker\Provider\Lorem::paragraph($nbSentences = 10, $variableNbSentences = true)
    ];
});

