<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Activity;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('prerequisite', 'corequisite')->where('is_deleted', false)->get()->values();
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
            'year_level' => $request->input('year_level'),
            'term' => $request->input('term'),
            'syllabus' => $request->input('syllabus'),
            'prerequisite_code' => $request->input('prerequisite_code'),
            'corequisite_code' => $request->input('corequisite_code'),
        ]);

        $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'subject',
                'description' => $fullname . ' created ' . $subject->code . ' ' . $subject->title . ' subject'
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
        $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        if($subject) {
            $subject->fill($request->all())->save();
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'subject',
                'description' => $fullname . ' updated ' . $subject->code . ' ' . $subject->title . ' subject'
            ]);
            return response()->json(['message' => 'Subject updated successfully', 'data' => $subject], 200);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $subjectToDelete = Subject::where('code', $request->code);
        if($subjectToDelete->count() > 0) {
            $subjectToDelete->update(['is_deleted' => true]);
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'subject',
                'description' => 'Subject ' . $request->code . ' deleted',
            ]);
            return response()->json(['message' => 'Subject deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }

    public function uploadSyllabus(Request $request, String $code) {
        $subject = Subject::where('code', $code)->get()->first();

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $fileName = time().'.'.$request->file->extension();
        $file = $request->file->move(public_path('uploads'), $fileName);

        $fullname = $request->user()->first_name.' '.$request->user()->last_name;

        Activity::create([
            'user_id' => $request->user_id,
            'type' => 'subject',
            'description' => $fullname . ' uploaded syllabus for ' . $subject->code . ' ' . $subject->title . ' subject'
        ]);

        if($subject) {
            $updated = $subject->update([
                'syllabus' => $fileName,
            ]);

            if($updated) {
                return response()->json(['message' => 'Syllabus uploaded successfully'], 200);
            } else {
                return response()->json(['message' => 'Syllabus not uploaded'], 500);
            }
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }
}
