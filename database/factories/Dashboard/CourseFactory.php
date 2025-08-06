<?php

namespace Database\Factories\Dashboard;

use App\Models\Admin\Admin;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
                'course_title' => $this->faker->sentence,
                'course_description' => $this->faker->paragraph,
                'status' => $this->faker->randomElement(['active', 'upcoming', 'deactivated', 'completed']),
                'price' => $this->faker->randomFloat(2, 10, 1000),

            ];
    }
}
