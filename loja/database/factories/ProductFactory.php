<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
      'title' => $faker->sentence(4),  
      'url' => $faker->imageUrl(640, 480, 'food',true),
      'description' => $faker->paragraph(),
      'amount' => $faker->randomFloat(2,10,5000),
      'height' => rand(2,105), 
      'length' => rand(16,105), 
      'width' => rand(11,105), 
      'weight' => $faker->randomFloat(3,0.1,10), 
    ];
});
