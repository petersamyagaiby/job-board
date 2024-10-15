<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['candidate_id'] = Auth::user()->candidate->id;
        $request->validate(
            [
                'candidate_id' => 'required',
                'job_post_id' => 'required',
                'body' => 'required|string',
            ]
        );

        Comment::create($request->all());
        return redirect()->back()->with('success', 'Comment added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request, Comment $comment)
    {
        $request['candidate_id'] = Auth::user()->candidate->id;
        $request->validate(
            [
                'candidate_id' => ['required', Rule::prohibitedIf(function () use ($comment) {
                    return
                        $comment->candidate_id !== Auth::user()->candidate->id;
                })],
                'body' => 'required|string',
            ],
            [
                'candidate_id.prohibited' => 'You are not allowed to edit this comment',
            ]
        );
        // dd($request->all(), $comment);
        $comment->update($request->all());
        return redirect()->back()->with('success', 'Comment updated successfully');
    }


    public function destroy(Comment $comment)
    {
        if ($comment->candidate_id !== Auth::user()->candidate->id) {
            return redirect()->back()->with('error', 'You are not allowed to delete this comment');
        }
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully');
    }
}
