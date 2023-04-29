<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => fake()->text(),
            "status"=> 1,
            'stars' => fake()->numberBetween($min = 1, $max = 5),
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
        ];
       
    }
}
