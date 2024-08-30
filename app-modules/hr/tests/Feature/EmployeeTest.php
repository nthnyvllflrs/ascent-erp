<?php

namespace Modules\Hr\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Hr\Models\Employee;
use Modules\Hr\Tests\HrServiceProviderTest as TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test employee list
     * @return void
     */
    public function test_list_employees()
    {
        Employee::factory()->hasCompensation(1)->count(5)->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson(route('hr.employees.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'firstname',
                        'lastname',
                        'email',
                        'mobile_number',
                        'telephone_number',
                        'address',
                        'birthday',
                        'created_at',
                        'updated_at',
                        'compensation' => [
                            'daily_rate',
                            'daily_working_hours',
                            'working_days',
                            'shift_start_time',
                            'shift_end_time',
                            'break_start_time',
                            'break_end_time',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            ]);

        $this->assertCount(5, $response['data']);
    }

    /**
     * Test employee create
     * @return void
     */
    public function test_create_employee()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('hr.employees.store', [
            'firstname'        => 'John',
            'lastname'         => 'Doe',
            'email'            => 'john.doe@employee.com',
            'mobile_number'    => '1234567890',
            'telephone_number' => '0987654321',
            'address'          => '123 Main St, Springfield, IL',
            'birthday'         => '1990-01-01',

            'daily_rate'          => 500,
            'daily_working_hours' => 8,
            'working_days'        => ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'],
            'shift_start_time'    => '08:00',
            'shift_end_time'      => '17:00',
            'break_start_time'    => '12:00',
            'break_end_time'      => '13:00',
        ]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'firstname',
                'lastname',
                'email',
                'mobile_number',
                'telephone_number',
                'address',
                'birthday',
                'created_at',
                'updated_at',
                'compensation' => [
                    'daily_rate',
                    'daily_working_hours',
                    'working_days',
                    'shift_start_time',
                    'shift_end_time',
                    'break_start_time',
                    'break_end_time',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseCount('employees', 1);
        $this->assertDatabaseCount('compensation', 1);
    }

    /**
     * Test employee update
     * @return void
     */
    public function test_show_employee()
    {
        $employee = Employee::factory()->hasCompensation(1)->create();
        $user     = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson(route('hr.employees.show', $employee->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'firstname',
                'lastname',
                'email',
                'mobile_number',
                'telephone_number',
                'address',
                'birthday',
                'created_at',
                'updated_at',
                'compensation' => [
                    'daily_rate',
                    'daily_working_hours',
                    'working_days',
                    'shift_start_time',
                    'shift_end_time',
                    'break_start_time',
                    'break_end_time',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /**
     * Test employee update
     * @return void
     */
    public function test_update_employee()
    {
        $employee = Employee::factory()->hasCompensation(1)->create();
        $user     = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->putJson(route('hr.employees.update', $employee->id), [
            'firstname'        => 'John',
            'lastname'         => 'Doe',
            'email'            => 'john.doe@employee.com',
            'mobile_number'    => '1234567890',
            'telephone_number' => '0987654321',
            'address'          => '123 Main St, Springfield, IL',
            'birthday'         => '1990-01-01',

            'daily_rate'          => 500,
            'daily_working_hours' => 8,
            'working_days'        => ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY'],
            'shift_start_time'    => '08:00',
            'shift_end_time'      => '17:00',
            'break_start_time'    => '12:00',
            'break_end_time'      => '13:00',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'firstname',
                'lastname',
                'email',
                'mobile_number',
                'telephone_number',
                'address',
                'birthday',
                'created_at',
                'updated_at',
                'compensation' => [
                    'daily_rate',
                    'daily_working_hours',
                    'working_days',
                    'shift_start_time',
                    'shift_end_time',
                    'break_start_time',
                    'break_end_time',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('employees', [
            'id'               => $employee->id,
            'firstname'        => 'John',
            'lastname'         => 'Doe',
            'email'            => 'john.doe@employee.com',
            'mobile_number'    => '1234567890',
            'telephone_number' => '0987654321',
            'address'          => '123 Main St, Springfield, IL',
            'birthday'         => '1990-01-01',
        ]);

        $this->assertDatabaseHas('compensation', [
            'daily_rate'          => 500,
            'daily_working_hours' => 8,
            // 'working_days'        => json_encode(['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY']), // todo: not working
            'shift_start_time'    => '08:00',
            'shift_end_time'      => '17:00',
            'break_start_time'    => '12:00',
            'break_end_time'      => '13:00',
        ]);
    }

    /**
     * Test employee delete
     * @return void
     */
    public function test_delete_employee()
    {
        $employee = Employee::factory()->hasCompensation(1)->create();
        $user     = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('hr.employees.destroy', $employee->id));

        $response->assertStatus(200);

        $this->assertDatabaseCount('employees', 0);
        $this->assertDatabaseCount('compensation', 0);
    }
}
