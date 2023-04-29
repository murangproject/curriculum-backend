<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments =  Department::all()->where('is_deleted', false)->values();
        if($departments) {
            return response()->json($departments, 200);
        } else {
            return response()->json(['message' => 'No departments found'], 404);
        }
    }

    public function archives() {
        $departments = Department::all()->where('is_deleted', true)->values();
        if($departments) {
            return response()->json($departments, 200);
        } else {
            return response()->json(['message' => 'No archived departments found'], 404);
        }
    }

    public function restore(Request $request) {
        $department = Department::find($request->id);
        if($department) {
            $department->is_deleted = false;
            $department->save();
            $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'department',
                'description' => 'Department ' . $department->name . ' restored by ' . $fullname . ' from archive'
            ]);
            return response()->json(['message' => 'Department restored successfully'], 200);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'code' => 'required|string|unique:departments,code',
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $department = Department::create($fields);
        $response = [
            'message' => 'Department created successfully',
            'data' => $department,
        ];

        if($department) {
            $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'department',
                'description' => 'Department ' . $department->name . ' was created by ' . $fullname
            ]);
            return response()->json($response, 201);
        } else {
            return response()->json(['message' => 'Department creation failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department = Department::find($department->id);
        if($department) {
            return response()->json($department, 200);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $fields = $request->validate([
            'code' => 'required|string|unique:departments,code,'.$request->id,
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $departmentToUpdate = Department::where('id', $request->id);

        if($departmentToUpdate->count() > 0) {
            $departmentToUpdate->update($fields);
            $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'department',
                'description' => 'Department ' . $departmentToUpdate->first()->name . ' was updated by ' . $fullname
            ]);
            $response = [
                'message' => 'Department updated successfully',
                'data' => $departmentToUpdate,
            ];
            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $departmentToDelete = Department::where('id', $request->id);
        if($departmentToDelete->count() > 0) {
            $departmentToDelete->update(['is_deleted' => true]);
            $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $response = [
                'message' => 'Department deleted successfully',
                'data' => $departmentToDelete,
            ];
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'department',
                'description' => 'Department ' . $departmentToDelete->first()->name . ' was deleted by ' . $fullname
            ]);
            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }
}
