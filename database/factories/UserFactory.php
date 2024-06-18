<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition ()
    {
        return [
            'first_name'    => $this->faker->firstName,
            'last_name'     => $this->faker->lastName,
            'username'      => $this->faker->userName,
            'password'      => \Illuminate\Support\Facades\Hash::make("parola"),
            'business_id'   => null,
            'is_admin'      => 0,
            'email'         => $this->faker->email,
            'phone'         => $this->faker->phoneNumber
        ];
    }
}
