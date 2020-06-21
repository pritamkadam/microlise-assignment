<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContentCategory;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ContentCategory::class, function (Faker $faker) {

    return [
        'name' => 'Video',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});
