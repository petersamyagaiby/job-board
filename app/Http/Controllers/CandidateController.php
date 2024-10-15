<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $candidate = $user->candidate->where('user_id', $user->id)->with('user')->first();
        return view('candidate.profile', compact('candidate'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        return view('candidate.edit', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $candidate->user->id,
            'regex:/^(?!.*\.\.)(?!.*\.$)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'phone_number' => 'required|string|min:10|max:15|unique:candidates,phone_number,' . $candidate->id,
            'regex:/^[0-9]{10,15}$/',
            'job_title' => 'required|string|max:255',
            'cv' => 'nullable|mimes:pdf,doc,docx,jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'candidates');

            if ($candidate->cv) {
                Storage::disk('candidates')->delete($candidate->cv);
            }

            $candidate->cv = $cvPath;
        }
        $candidate->user->name = $request->name;
        $candidate->user->email = $request->email;
        $candidate->user->save();

        $candidate->update([
            'phone_number' => $request->phone_number,
            'job_title' => $request->job_title,
        ]);

        return redirect()->route('candidate.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {

        if ($candidate->cv) {
            $disk = Storage::disk('candidates');
            $candidateCv = $candidate->cv;

            if ($disk->exists($candidateCv)) {
                $disk->delete($candidateCv);
            }
        }
        $user = $candidate->user;
        $user->delete();
        $candidate->delete();

        Auth::logout();
        return redirect()->route('homepage')->with('success', 'Profile deleted successfully.');
    }
}
