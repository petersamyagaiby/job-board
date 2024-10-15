<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\JobPost;
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
    public function definition(): array
    {
        $jobPostIds = JobPost::pluck("id")->toArray();
        $candidateIds = Candidate::pluck("id")->toArray();
        return [
            'job_post_id' => fake()->randomElement($jobPostIds),
            'candidate_id' => fake()->randomElement($candidateIds),
            'body' => fake()->paragraph(),
        ];
    }
}
