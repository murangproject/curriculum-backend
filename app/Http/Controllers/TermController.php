<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Term::all()->where('is_deleted', false)->values();
        if($terms) {
            return response()->json($terms, 200);
        } else {
            return response()->json(['message' => 'No terms found'], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'month' => 'required|string',
        ]);

        $term = Term::create($fields);
        if($term) {
            return response()->json(['message' => 'Term created successfully', 'data' => $term], 200);
        } else {
            return response()->json(['message' => 'Term not created'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $termToDelete = Term::where('id', $request->id);
        if($termToDelete->count() > 0) {
            $termToDelete->update(['is_deleted' => true]);
            return response()->json(['message' => 'Term deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Term not found'], 404);
        }
    }
}
