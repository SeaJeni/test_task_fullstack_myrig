<?php


namespace Database\Factories;
use App\Models\Employee;
use \Illuminate\Database\Eloquent\Factories\Factory;


class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    /**
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'date_of_birth' => $this->faker->dateTime,
            'weight' => rand(100,200),
            'height' => rand(4,6)."'".rand(1,11).'"',
            'salary' => rand(1000,2000),
            'position' => $this->faker->randomElement(["Developer", "Manager", "QA", "Accountant"]),
        ];
    }
}
