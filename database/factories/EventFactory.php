<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama'      => $this->faker->words(3, true),
            'keterangan'=> $this->faker->words(10, true),
            'password'  => Str::random(4),
            'slug'      => strtolower(Str::random(10)),
            'status'    => $this->faker->randomElement(['n','y']),
        ];
    }
}
