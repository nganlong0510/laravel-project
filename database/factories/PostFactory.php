<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function configure()
    {
        // After creating a Post, continue creating 3 comments for the post created.
        $function = function (Post $post) {
            $post->comments()->saveMany(
                Comment::factory(3)->make()
            );
            $post->categories()->attach(
                Category::all()->random(2)->pluck('id')->toArray()
            );
        };
        return $this->afterCreating($function);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(10, true),
            'description' => $this->faker->sentence(),
            'user_id' => User::all()->random()->id,
        ];
    }
}
