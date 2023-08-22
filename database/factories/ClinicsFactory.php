<?php

namespace Database\Factories;

use App\Models\Clinics;
use Illuminate\Database\Eloquent\Factories\Factory;


class ClinicsFactory extends Factory
{
    protected $model = Clinics::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'township' => $this->faker->city(),
            'phone' => $this->faker->phoneNumber(),
            'opening_hour' => $this->faker->time(),
            'closing_hour' => $this->faker->time()
        ];
    }
}
