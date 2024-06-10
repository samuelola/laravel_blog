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
            'content' => fake()->paragraph(5,true),
            'created_at' => fake()->dateTimeBetween('-3 months')
        ];
    }

    public function unverified():static
    {
        return $this->state(fn (array $attributes)=>[

            'created_at' => null,
        ]);
    }

    // public function newTitle()
    // {
    //     return $this->state(fn (array $attributes)=>[

    //         'title' => 'New title'
    //     ]);
    // }

        public function newTitle(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'New title',
                'content' => 'New content for blog post'
            ];
        });
    }
}
