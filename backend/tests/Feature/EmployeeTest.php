<?php

namespace Tests\Feature;

use App\Models\Employee;
use Database\Factories\EmployeeFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteAction()
    {
        /** @var Employee $model */
        $model = Employee::factory()->create();

        $response = $this->deleteJson(route('employees.delete', ['employee' => $model]));
        $response->assertOk()->assertJson(['data' => [
            'id' => $model->id,
            'first_name'=> $model->first_name,
            'last_name'=> $model->last_name,
            'date_of_birth'=> $model->date_of_birth->format('Y-m-d'),
            'weight'=> $model->weight,
            'height'=> $model->height,
            'salary'=> $model->salary,
            'position'=> $model->position,
        ]]);
        $this->assertDatabaseHas('employees', ['id' => $model->id]);
    }

    public function testDeleteActionOnNotFound()
    {
        $response = $this->deleteJson(route('employees.delete', ['employee' => 1]));
        $response->assertNotFound();
    }
}
