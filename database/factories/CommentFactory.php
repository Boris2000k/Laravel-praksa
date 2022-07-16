<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

$factory->define(App\Models\Comment::class,function (Faker $faker){
    return [
        'content' => $faker->text
    ];

});
// class CommentFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array
//      */
//     public function definition()
//     {
//         return [
//             'content' => $faker->text
//         ];
//     }
// }
