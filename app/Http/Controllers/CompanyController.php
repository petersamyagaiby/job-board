<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $company = $user->company->where('user_id', $user->id)->with('user')->first();
        return view('company.profile', compact('company'));
    }

    public function allJobs()
    {
        $softDeletedJobs = [];
        $companyId = Auth::user()->company->id;
        $jobs = JobPost::where('company_id', $companyId)->orderBy('created_at', 'desc')->get();
        $softDeletedJobs = JobPost::onlyTrashed()->where('company_id', $companyId)->get();
        return view("company.jobs", compact("jobs", "softDeletedJobs"));
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
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $company->user->id,
            'regex:/^(?!.*\.\.)(?!.*\.$)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'contact_phone' => 'required|string|min:10|max:15|unique:companies,contact_phone,' . $company->id,
            'regex:/^[0-9]{10,15}/',
            'description' => 'required|string|max:255',
            'logo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'companies');

            if ($company->logo) {
                Storage::disk('companies')->delete($company->logo);
            }
            $company->logo = $logoPath;
        }

        $company->user->name = $request->name;
        $company->user->email = $request->email;
        $company->user->save();

        $company->update([
            'contact_phone' => $request->contact_phone,
            'description' => $request->description,
        ]);

        return redirect()->route('company.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if ($company->logo) {
            $disk = Storage::disk('companies');
            $companyLogo = $company->logo;

            if ($disk->exists($companyLogo)) {
                $disk->delete($companyLogo);
            }
        }
        $user = $company->user;
        $user->delete();
        $company->delete();

        Auth::logout();
        return redirect()->route('homepage')->with('success', 'Profile deleted successfully.');
    }
}
