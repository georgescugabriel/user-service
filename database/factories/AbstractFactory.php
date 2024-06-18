<?php

namespace Database\Factories;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbstractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AbstractModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition ()
    {
        return [
            'name'  => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
