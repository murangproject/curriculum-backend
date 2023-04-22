<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all()->where('deleted', false)->values();
        if($subjects) {
            return response()->json($subjects, 200);
        } else {
            return response()->json(['message' => 'No subjects found'], 404);
        }
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'code' => 'required|string|unique:subjects,code',
            'title' => 'required|string',
            'lab_unit' => 'required|integer',
            'lec_unit' => 'required|integer',
            'description' => 'nullable|string',
            'syllabus' => 'nullable|string',
        ]);

        $subject = Subject::create($fields);
        if($subject) {
            return response()->json(['message' => 'Subject created successfully', 'data' => $subject], 200);
        } else {
            return response()->json(['message' => 'Subject not created'], 500);
        }
    }

    public function show(Subject $subject)
    {
        //
    }

    public function update(Request $request)
    {
        $fields = $request->validate([
            'code' => 'required|string|unique:subjects,code,'.$request->id,
            'title' => 'required|string',
            'lab_unit' => 'required|integer',
            'lec_unit' => 'required|integer',
            'description' => 'nullable|string',
            'syllabus' => 'nullable|string',
        ]);

        $subject = Subject::where('id', $request->id);
        if($subject->count() > 0) {
            $subject->update($fields);
            return response()->json(['message' => 'Subject updated successfully', 'data' => $subject], 200);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $subjectToDelete = Subject::where('id', $request->id);
        if($subjectToDelete->count() > 0) {
            $subjectToDelete->update(['deleted' => true]);
            return response()->json(['message' => 'Subject deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }
}
