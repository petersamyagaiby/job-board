<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['type' => 'candidate']),
            'phone_number' => fake()->unique()->phoneNumber(),
            'job_title' => fake()->jobTitle(),
            'cv' => 'cv/' . Str::random(10) . '.' . $this->faker->fileExtension(),
        ];
    }
}
