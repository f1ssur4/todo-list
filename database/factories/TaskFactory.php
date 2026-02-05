<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
	public function definition(): array
	{
		return [
			'user_id' => User::factory(),
			'category_id' => null,
			'title' => fake()->sentence(4),
			'description' => fake()->optional()->paragraph(),
			'priority' => fake()->randomElement(['low', 'medium', 'high']),
			'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
			'deadline' => fake()->optional()->dateTimeBetween('now', '+30 days'),
			'completed_at' => null,
		];
	}

	public function withCategory(): static
	{
		return $this->state(fn (array $attributes) => [
			'category_id' => Category::factory()->create([
				'user_id' => $attributes['user_id'],
			])->id,
		]);
	}

	public function completed(): static
	{
		return $this->state(fn (array $attributes) => [
			'status' => 'completed',
			'completed_at' => now(),
		]);
	}

	public function overdue(): static
	{
		return $this->state(fn (array $attributes) => [
			'status' => 'pending',
			'deadline' => fake()->dateTimeBetween('-7 days', '-1 day'),
		]);
	}
}
