<?php

namespace Modules\Hr\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Hr\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()
            ->json(Employee::with('compensation')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // employee
            'firstname'                      => ['required', 'string'],
            'lastname'                       => ['required', 'string'],
            'email'                          => ['required', 'email'],
            'mobile_number'                  => ['required', 'string'],
            'telephone_number'               => ['required', 'string'],
            'address'                        => ['required', 'string'],
            'birthday'                       => ['required', 'date'],
            'emergency_contact_name'         => ['required', 'string'],
            'emergency_contact_number'       => ['required', 'string'],
            'emergency_contact_relationship' => ['required', 'string'],
            'job_title'                      => ['required', 'string'],
            'department'                     => ['required', 'string'],
            'employment_status'              => ['required', 'string'],
            'date_hired'                     => ['required', 'date'],

            // compensation information
            'daily_rate'                     => ['required', 'numeric'],
            'daily_working_hours'            => ['required', 'numeric'],
            'overtime_multiplier'            => ['required', 'numeric'],
            'holiday_multiplier'             => ['required', 'numeric'],
            'special_holiday_multiplier'     => ['required', 'numeric'],
            'shift_start_time'               => ['required', 'date_format:H:i'],
            'shift_end_time'                 => ['required', 'date_format:H:i'],
            'break_start_time'               => ['required', 'date_format:H:i'],
            'break_end_time'                 => ['required', 'date_format:H:i'],
            'late_grace_period'              => ['required', 'numeric'],
        ]);

        $employee = Employee::create([
            'firstname'                      => $validated['firstname'],
            'lastname'                       => $validated['lastname'],
            'email'                          => $validated['email'],
            'mobile_number'                  => $validated['mobile_number'],
            'telephone_number'               => $validated['telephone_number'],
            'address'                        => $validated['address'],
            'birthday'                       => $validated['birthday'],
            'emergency_contact_name'         => $validated['emergency_contact_name'],
            'emergency_contact_number'       => $validated['emergency_contact_number'],
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'],
            'job_title'                      => $validated['job_title'],
            'department'                     => $validated['department'],
            'employment_status'              => $validated['employment_status'],
            'date_hired'                     => $validated['date_hired'],
        ]);

        $employee->compensation()->create([
            'daily_rate'                 => $validated['daily_rate'],
            'daily_working_hours'        => $validated['daily_working_hours'],
            'overtime_multiplier'        => $validated['overtime_multiplier'],
            'holiday_multiplier'         => $validated['holiday_multiplier'],
            'special_holiday_multiplier' => $validated['special_holiday_multiplier'],
            'shift_start_time'           => $validated['shift_start_time'],
            'shift_end_time'             => $validated['shift_end_time'],
            'break_start_time'           => $validated['break_start_time'],
            'break_end_time'             => $validated['break_end_time'],
            'late_grace_period'          => $validated['late_grace_period'],
        ]);

        return response()
            ->json($employee->load('compensation'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $employee)
    {
        $employee = Employee::findOrFail($employee);
        return response()
            ->json($employee->load('compensation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $employee)
    {
        $validated = $request->validate([
            // employee information
            'firstname'                      => ['required', 'string'],
            'lastname'                       => ['required', 'string'],
            'email'                          => ['required', 'email'],
            'mobile_number'                  => ['required', 'string'],
            'telephone_number'               => ['required', 'string'],
            'address'                        => ['required', 'string'],
            'birthday'                       => ['required', 'date'],
            'emergency_contact_name'         => ['required', 'string'],
            'emergency_contact_number'       => ['required', 'string'],
            'emergency_contact_relationship' => ['required', 'string'],
            'job_title'                      => ['required', 'string'],
            'department'                     => ['required', 'string'],
            'employment_status'              => ['required', 'string'],
            'date_hired'                     => ['required', 'date'],

            // compensation information
            'daily_rate'                     => ['required', 'numeric'],
            'daily_working_hours'            => ['required', 'numeric'],
            'overtime_multiplier'            => ['required', 'numeric'],
            'holiday_multiplier'             => ['required', 'numeric'],
            'special_holiday_multiplier'     => ['required', 'numeric'],
            'shift_start_time'               => ['required', 'date_format:H:i'],
            'shift_end_time'                 => ['required', 'date_format:H:i'],
            'break_start_time'               => ['required', 'date_format:H:i'],
            'break_end_time'                 => ['required', 'date_format:H:i'],
            'late_grace_period'              => ['required', 'numeric'],
        ]);

        $employee = Employee::findOrFail($employee);
        $employee->update([
            'firstname'                      => $validated['firstname'],
            'lastname'                       => $validated['lastname'],
            'email'                          => $validated['email'],
            'mobile_number'                  => $validated['mobile_number'],
            'telephone_number'               => $validated['telephone_number'],
            'address'                        => $validated['address'],
            'birthday'                       => $validated['birthday'],
            'emergency_contact_name'         => $validated['emergency_contact_name'],
            'emergency_contact_number'       => $validated['emergency_contact_number'],
            'emergency_contact_relationship' => $validated['emergency_contact_relationship'],
            'job_title'                      => $validated['job_title'],
            'department'                     => $validated['department'],
            'employment_status'              => $validated['employment_status'],
            'date_hired'                     => $validated['date_hired'],
            'date_regularized'               => $validated['date_regularized'] ?? NULL,
            'date_resigned'                  => $validated['date_resigned'] ?? NULL,
            'date_terminated'                => $validated['date_terminated'] ?? NULL,
        ]);

        $employee->compensation()->update([
            'daily_rate'                 => $validated['daily_rate'],
            'daily_working_hours'        => $validated['daily_working_hours'],
            'overtime_multiplier'        => $validated['overtime_multiplier'],
            'holiday_multiplier'         => $validated['holiday_multiplier'],
            'special_holiday_multiplier' => $validated['special_holiday_multiplier'],
            'shift_start_time'           => $validated['shift_start_time'],
            'shift_end_time'             => $validated['shift_end_time'],
            'break_start_time'           => $validated['break_start_time'],
            'break_end_time'             => $validated['break_end_time'],
            'late_grace_period'          => $validated['late_grace_period'],
        ]);

        return response()
            ->json($employee->load('compensation'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $employee)
    {
        $employee = Employee::findOrFail($employee);
        $employee->delete();

        return response()
            ->json($employee, 204);
    }
}
