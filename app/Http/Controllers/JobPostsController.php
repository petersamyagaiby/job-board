<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobsRequest;
use App\Http\Requests\UpdateJobsRequest;
use App\Models\Application;
use App\Models\Category;
use App\Models\City;
use App\Models\Technology;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class JobPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $cities = City::all();
        $jobs = JobPost::orderBy('created_at', 'desc')->paginate(5);
        $technologies = Technology::all();
        return view("jobs.index", compact("jobs", "categories", "cities", "technologies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technologis = Technology::all();
        $categories = Category::all();
        $cities = City::all();
        return view("jobs.create", compact("cities", "technologis", "categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobsRequest $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company->id;
        $job = JobPost::create($data);
        foreach ($data['technologis'] as $technology) {
            $job->technologies()->attach($technology);
        }
        foreach ($data['categories']  as $category) {
            $job->categories()->attach($category);
        }
        return to_route("jobs.show", $job)->with('success', 'Job Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job)
    {
        $application = null;

        if (isset(Auth::user()->candidate)) {
            $application =  Application::where('job_post_id', $job->id)->where('candidate_id', Auth::user()->candidate->id)->first();
        }
        return view("jobs.show", compact("job", 'application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job)
    {
        $technologis = Technology::all();
        $categories = Category::all();
        $cities = City::all();
        $workType = ["onsite", "remote", "hybrid", "freelance"];
        return view("jobs.edit", compact("job", 'workType', 'cities', 'technologis', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, JobPost $job)
    public function update(UpdateJobsRequest $request, JobPost $job)
    {
        $oldTecIds = $job->technologies->pluck('id')->toArray();
        foreach ($oldTecIds as $oldID) {
            if (!in_array($oldID, $request['technologis'])) {
                $job->technologies()->detach($oldID);
            }
        }

        foreach ($request['technologis'] as $tec) {
            if (!in_array($tec, $oldTecIds)) {
                $job->technologies()->attach($tec);
            }
        }
        $oldCatIds = $job->categories->pluck('id')->toArray();

        foreach ($oldCatIds as $oldID) {
            if (!in_array($oldID, $request['categories'])) {
                $job->categories()->detach($oldID);
            }
        }

        foreach ($request['categories'] as $tec) {
            if (!in_array($tec, $oldCatIds)) {
                $job->categories()->attach($tec);
            }
        }

        $job->update($request->all());
        return to_route("jobs.show", compact('job'))->with('success', 'Job Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job)
    {
        $job->delete();
        return to_route("company.jobs");
    }

    public function trashed(JobPost $job)
    {
        $softDeletedJobs = JobPost::onlyTrashed()->where('company_id', Auth::user()->company->id)->get();
        return view("jobs.trashed", compact("softDeletedJobs"));
    }

    public function restore(string $id)
    {
        $job = JobPost::onlyTrashed()->findOrFail($id);
        $job->restore();
        if (JobPost::onlyTrashed()->count() > 0) {
            return to_route("jobs.trashed");
        } else {
            return to_route("company.jobs");
        }
    }

    public function forceDelete(string $id)
    {
        $job = JobPost::onlyTrashed()->findOrFail($id);
        $job->forceDelete();
        if (JobPost::onlyTrashed()->count() > 0) {
            return to_route("jobs.trashed");
        } else {
            return to_route("company.jobs");
        }
    }

    public function applications(JobPost $job)
    {
        $applications = Application::where("job_post_id", $job->id)->get();
        return view("application.index", compact("applications"));
    }

    public function accept(Application $application)
    {
        $application->accept();
        return redirect()->back()->with('accepted', 'Application Accepted');
    }

    public function reject(Application $application)
    {
        $application->reject();
        return redirect()->back()->with('success', 'Application Rejected');
    }

    public function review(Application $application)
    {
        $application->review();
        return redirect()->back()->with('success', 'Application Reviewed');
    }

    public function filter(Request $request)
    {
        $query = JobPost::query();

        if ($request->filled('keywords')) {
            $keywords = $request->input('keywords');
            $query->where(function ($q) use ($keywords) {
                $q->where('title', 'like', "%{$keywords}%")
                    ->orWhere('work_type', 'like', "%{$keywords}%")
                    ->orWhere('responsibilities', 'like', "%{$keywords}%")
                ;
            });
        }

        if ($request->filled('technology')) {
            $technologyIds = $request->input('technology');
            $query->orWhereHas('technologies', function ($q) use ($technologyIds) {
                $q->where('technologies.id', $technologyIds);
            });
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->input('city_id'));
        }

        if ($request->filled('category')) {
            $categoryId = $request->input('category');
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        if ($request->filled('min_salary')) {
            $minSalary = $request->input('min_salary');
            $query->where('max_salary', '>=', $minSalary)
                ->where('min_salary', '<=', $minSalary);
        }

        if ($request->filled('max_salary')) {
            $maxSalary = $request->input('max_salary');
            $query->where('max_salary', '>=', $maxSalary)
                ->where('min_salary', '<=', $maxSalary);
        }

        $jobs = $query->where('is_active', 1)->paginate(5);
        $categories = Category::all();
        $cities = City::all();
        $technologies = Technology::all();

        return view('jobs.index', compact('jobs', 'cities', 'categories', 'technologies'));
    }

    public function search()
    {
        $categories = Category::all();
        $cities = City::all();
        return view('jobs.search', compact('categories', 'cities'));
    }
}
