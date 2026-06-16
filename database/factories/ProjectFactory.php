<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
final class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title($this->faker->word().' '.$this->faker->word());

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1, 99999),
            'tagline' => $this->faker->sentence(10),
            'body' => $this->faker->paragraphs(4, true),
            'role' => $this->faker->randomElement(['Solo build', 'Lead developer', 'Design & build']),
            'client' => $this->faker->company(),
            'year' => (string) $this->faker->numberBetween(2021, 2026),
            'tech_stack' => $this->faker->randomElements(
                ['Laravel', 'Livewire', 'Vue', 'Tailwind', 'Postgres', 'Redis', 'Inertia', 'Stripe'],
                3
            ),
            'live_url' => $this->faker->url(),
            'repo_url' => null,
            'cover_image' => null,
            'status' => $this->faker->randomElement(['Live', 'Shipped']),
            'is_featured' => false,
            'sort_order' => $this->faker->numberBetween(0, 50),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => ['is_featured' => true]);
    }
}
