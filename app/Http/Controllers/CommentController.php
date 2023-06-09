<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required|integer',
            'curriculum_id'=> 'required|integer',
            'content' => 'required|string',
        ]);

        $fullname = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $comment = Comment::create($fields);
        if($comment) {
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'comment',
                'description' => $fullname . ' added feedback on curriculum titled ' . $comment->curriculum->title
            ]);
            Activity::create([
                'user_id' => auth()->user()->id,
                'type' => 'curriculum',
                'description' => $fullname . ' added feedback on curriculum titled ' . $comment->curriculum->title
            ]);
            return response()->json(['message' => 'Comment created successfully', 'data' => $comment], 200);
        } else {
            return response()->json(['message' => 'Comment not created'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $comment = Comment::where('id', $request->id)->first();
        if($comment) {
            $comment->delete();
            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Comment not found'], 404);
        }
    }
}
