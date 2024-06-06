<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10),
            'content' => fake()->paragraph(5,true)
        ];
    }

    public function unverified():static
    {
        return $this->state(fn (array $attributes)=>[

            'created_at' => null,
        ]);
    }

    public function newTitle()
    {
        return $this->state(fn (array $attributes)=>[

            'title' => 'New title'
        ]);
    }
}
