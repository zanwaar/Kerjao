<?php

namespace Database\Factories;

use App\Models\GithubActivity;
use App\Models\Pegawai;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GithubActivity>
 */
class GithubActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id' => TodoList::factory(),
            'pegawai_id' => Pegawai::factory(),
            'repo_name' => fake()->userName() . '/' . fake()->slug(2),
            'branch_name' => fake()->randomElement(['main', 'develop', 'feature/' . fake()->slug(2)]),
            'issue_link' => fake()->optional()->url(),
            'pr_link' => fake()->optional()->url(),
            'commit_hash' => fake()->optional()->sha1(),
            'commit_message' => fake()->optional()->sentence(),
            'commit_time' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
