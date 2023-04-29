<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $industries = Industry::pluck('id')->toArray();
        return [
            'name' => fake()->name(),
            'logo' => fake()->imageUrl(),
            'website' => fake()->url(),
            'founded' => fake()->year(),
            'user_id' => User::factory(),
            'industry_id' => Arr::random($industries),
            'employees' => fake()->numberBetween($min = 1, $max = 1000),
            'revenue' => fake()->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100000000),
            'description' => fake()->paragraphs($nb = 3, $asText = true),
            'country_code' => fake()->countryCode(),
            'city' => fake()->city(),
            'address' => fake()->address(),
            'mission' => fake()->sentence(),
            


        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Company $company) {
            $followers = User::factory()->count(3)->create();
            $company->followers()->attach($followers);
        });
    }
       
    
}
