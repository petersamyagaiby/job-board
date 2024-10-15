<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
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
        dd('TTTTTTTTTTTTTTTT');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request['candidate_id'] = Auth::user()->candidate->id;
        $request->validate(
            [
                'job_post_id' =>  'unique:applications,job_post_id,NULL,id,candidate_id,' . $request->candidate_id,
                // 'job_post_id' => 'required',
                'candidate_id' => 'required',
                'status' => 'pending',
            ],
            [
                'job_post_id.unique' => 'You have already applied for this job',
            ]

        );
        $application = Application::create($request->all());

        return redirect()->route('jobs.show', $request['job_post_id'])->with('success', 'Application submitted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        if ($application->candidate_id == Auth::user()->candidate->id) {
            $application->delete();
            return redirect()->route('jobs.show', $application->job_post_id)->with('success', 'Application Canceled successfully');
        } else {
            return redirect()->route('jobs.show', $application->job_post_id)->with('error', 'You did not applied for this job');
        }
    }
}
