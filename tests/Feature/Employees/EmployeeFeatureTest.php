<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 19:06
 */

namespace Tests\Feature\Employees;


use App\Shop\Employees\Employee;
use Tests\TestCase;

class EmployeeFeatureTest extends TestCase
{
    /** @test */
    public function it_errors_when_editing_an_employee_that_is_not_found()
    {
        $this->actingAs($this->employee, 'admin')
            ->get(route('employees.edit', 9999))
            ->assertStatus(404);
    }

    /** @test */
    public function it_errors_when_looking_for_an_employee_that_is_not_found()
    {
        $this->actingAs($this->employee, 'admin')
            ->get(route('employees.show', 9999))
            ->assertStatus(404);
    }

    /** @test */
    public function it_errors_when_the_email_is_already_taken()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->employee->email,
            'password' => 'secret'
        ];
        $this->actingAs($this->employee, 'admin')
            ->post(route('employees.store', $data))
            ->assertStatus(302)
            ->assertSessionHas(['errors']);
    }

    /** @test */
    public function it_errors_if_the_password_is_less_than_eight_caracters()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];
        $this->actingAs($this->employee, 'admin')
            ->post(route('employees.store', $data))
            ->assertStatus(302)
            ->assertSessionHas(['errors']);
    }

    /** @test */
    public function it_can_only_soft_delete_an_employee()
    {
        $employee = factory(Employee::class, 20)->create();

        $this->actingAs($this->employee, 'admin')
            ->delete(route('employees.destroy', $employee->id))
            ->assertStatus(302)
            ->assertRedirect(route('employees.index'));
    }

    /** @test */
    public function it_can_update_employees_password()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'status' => 1,
            'password' => 'unknown'
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('employees.update', $this->employee->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('employees.edit', $this->employee->id));

        $collection = collect($data)->except('password');

        $this->assertDatabaseHas('employees', $collection->all());
    }

    /** @test */
    public function it_can_list_all_the_employees()
    {
        factory(Employee::class, 20)->create();

        $this->actingAs($this->employee, 'admin')
            ->get(route('employees.index'))
            ->assertViewHas(['employees']);
    }

    /** @test */
    public function it_can_show_the_employee()
    {
        $this->actingAs($this->employee, 'admin')
            ->get(route('employees.show', $this->employee->id))
            ->assertStatus(200)
            ->assertViewHas(['employee']);
    }

    /** @test */
    public function it_can_update_the_employee()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('employees.update', $this->employee->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('employees.edit', $this->employee->id));

        $this->assertDatabaseHas('customers', $data);
    }

    /** @test */
    public function it_can_create_an_employee()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret!!'
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('employees.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('employees.index'));

        $created = collect($data)->except('password');

        $this->assertDatabaseHas('employees', $created->all());
    }
}
