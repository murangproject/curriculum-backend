<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculums = Curriculum::with('subjects')->where('is_deleted', false)->get()->values();
        if($curriculums) {
            return response()->json($curriculums, 200);
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

    public function addSubjectToCurriculum(Request $request)
    {
        $curriculum = Curriculum::find($request->curriculum_id);
        $curriculum->subjects()->attach($request->subject_id);
        return response()->json(['message' => 'Subject added to curriculum successfully'], 200);
    }

    public function addSubjectsToCurriculum(Request $request) {
        $curriculum = Curriculum::find($request->id);

        $attachedIds = $curriculum->subjects()->whereIn('code', $request->subject_ids)->pluck('code');
        $newIds = array_diff($request->subject_ids, $attachedIds->values()->all());
        $curriculum->subjects()->attach($newIds);
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
        //
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
    public function destroy(Curriculum $curriculum)
    {
        $curriculumToDelete = Curriculum::where('id', $curriculum->id);
        if($curriculumToDelete->count() > 0) {
            $curriculumToDelete->update(['deleted' => true]);
            return response()->json(['message' => 'Curriculum deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Curriculum not found'], 404);
        }
    }
}
