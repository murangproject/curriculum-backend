<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('prerequisite')->where('is_deleted', false)->get()->values();
        return response()->json($subjects, 200);
        if($subjects) {
            return response()->json($subjects, 200);
        } else {
            return response()->json(['message' => 'No subjects found'], 404);
        }
    }

    public function store(SubjectRequest $request)
    {
        $subject = Subject::create([
            'code' => $request->input('code'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'units' => $request->input('units'),
            'hours' => $request->input('hours'),
            'syllabus' => $request->input('syllabus'),
            'prerequisite_id' => $request->input('prerequisite_id'),
            'corequisite_id' => $request->input('corequisite_id'),
        ]);

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

    public function update(SubjectRequest $request, String $code)
    {
        $subject = Subject::where('code', $code)->get()->first();
        if($subject) {
            $subject->fill($request->all())->save();
            return response()->json(['message' => 'Subject updated successfully', 'data' => $subject], 200);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $subjectToDelete = Subject::where('id', $request->id);
        if($subjectToDelete->count() > 0) {
            $subjectToDelete->update(['is_deleted' => true]);
            return response()->json(['message' => 'Subject deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }
}
