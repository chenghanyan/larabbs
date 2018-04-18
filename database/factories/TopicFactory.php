<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

	$sentence = $faker->sentence();
	//随机取一个月以内的时间
	$update_at = $faker->dateTimeThisMonth();
	//传参为生成最大时间超过，创建时间永远比更改时间要早
	$created_at = $faker->dateTimeThisMonth($update_at);
    return [
        'title' => $sentence,
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'created_at' => $created_at,
        'updated_at' => $update_at,
    ];
});
