<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => $this->faker->name(),
            'email'   => $this->faker->unique()->safeEmail(),
            'phone'   => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'company' => $this->faker->company(),
        ];
    }
}
