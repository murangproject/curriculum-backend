<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Department;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculums = Curriculum::with('subjects', 'department', 'comments', 'comments.user', 'comments.curriculum')->where('is_deleted', false)->get()->values();
        $filteredCurriculumns = $curriculums->map(function($curriculum) {
            if(Department::where('id', $curriculum->department_id)->where('is_deleted', false)->first()) {
                return $curriculum;
            }
        });
        if($filteredCurriculumns) {
            return response()->json($filteredCurriculumns, 200);
        } else {
            return response()->json(['message' => 'No curriculums found'], 404);
        }
    }

    public function getCurriculumWithSubjects(int $id)
    {
        $curriculumWithSubjects = Curriculum::find('id', $id)->load('subjects');
        return response()->json($curriculumWithSubjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'department_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $curriculum = Curriculum::create($fields);
        if($curriculum) {
            return response()->json(['message' => 'Curriculum created successfully', 'data' => $curriculum], 200);
        } else {
            return response()->json(['message' => 'Curriculum not created'], 500);
        }
    }

    public function addSubjectsToCurriculum(Request $request) {
        $curriculum = Curriculum::find($request->id);
        $curriculum->subjects()->sync($request->subject_ids);
        return response()->json(['message' => 'Subjects added to curriculum successfully'], 200);
    }

    public function removeSubjectsFromCurriculum(Request $request) {
        $curriculum = Curriculum::find($request->id);
        $curriculum->subjects()->detach($request->subject_ids);
        return response()->json(['message' => 'Subjects removed from curriculum successfully'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $curriculumToUpdate = Curriculum::where('id', $request->id);
        if($curriculumToUpdate->count() > 0) {
            $fields = $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
            ]);
            $curriculumToUpdate->update($fields);
            return response()->json(['message' => 'Curriculum updated successfully', 'data' => $curriculumToUpdate], 200);
        } else {
            return response()->json(['message' => 'Curriculum not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $curriculumToDelete = Curriculum::where('id', $request->id);
        if($curriculumToDelete->count() > 0) {
            $curriculumToDelete->update(['is_deleted' => true]);
            return response()->json(['message' => 'Curriculum deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Curriculum not found'], 404);
        }
    }
}
