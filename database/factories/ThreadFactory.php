<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->word,
            'slug' =>  Str::of($this->faker->word)->slug('-'),
            'body' => $this->faker->realText(100),
            'user_id' => rand(1, 9),
            'channel_id' => rand(1, 20)
        ];
    }
}
