<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Review;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content' => fake()->paragraphs(3, true),
            "status"=> 1,
            'user_id' => User::factory(),
            'review_id' => Review::factory(),
        ];
    }
}
