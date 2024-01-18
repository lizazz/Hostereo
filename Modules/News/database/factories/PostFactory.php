<?php

namespace Modules\News\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\News\app\Models\Tag;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\News\app\Models\Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'translations' => []
        ];
    }
}

