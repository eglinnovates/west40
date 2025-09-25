<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory {

    protected $model = Student::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'dob' => $this->faker->dateTimeBetween('-24 years', '-12 years')->format('Y-m-d'),
        ];
    }
}
