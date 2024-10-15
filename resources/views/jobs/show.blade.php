@extends('layouts.app')

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel">Alert</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are You sure you want to delete this job?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form class="row p-0 m-0" action="{{ route('jobs.destroy', $job->id) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-center pt-5 fw-bolder fftitle codark">Job Details</h1>
    <div class="row mt-3 mb-5 px-3">
        <div class="d-flex justify-content-end mb-5">
            <a href="{{ route('jobs.index') }}" class="btn bgprimary cowhite fw-bolder fs-4">Back To All Jobs</a>
        </div>
        <div class="col-lg-8">
            <div class="row mb-5">
                <div class="col-2">
                    <img src="{{ asset('assets/images/company/logo.jpg') }}" width="100" height="100"
                        style="border: 1px solid #dee2e6 !important">
                </div>
                <div class="col-10">
                    <h2 class="fftitle codark fw-bold">{{ $job->title }}</h2>
                    <p class="">Company Name: {{ $job->company->company_name }}</p>
                    <span class=" me-3">
                        <i class="fa-solid fa-location-dot coprimary me-1"></i>
                        {{ $job->city->name }}
                    </span>
                    <span class=" me-3">
                        <i class="fa-regular fa-clock coprimary me-1"></i>
                        {{ $job->work_type == 'onsite' ? 'On Site' : ($job->work_type == 'remote' ? 'Remote' : ($job->work_type == 'hybrid' ? 'Hybrid' : 'Freelance')) }}
                    </span>
                    <span class=" me-3">
                        <i class="fa-regular fa-money-bill-1 coprimary me-1"></i>
                        {{ $job->min_salary }} - {{ $job->max_salary }}
                    </span>
                </div>
            </div>
            <div class="my-4">
                <h2 class="fw-bold my-3 fftitle codark">Job Description</h2>
                <p class="">{{ $job->description }}</p>
            </div>
            <div class="my-4">
                <h2 class="fw-bold my-3 fftitle codark">Responsibility</h2>
                <p class="">{{ $job->responsibilities }}</p>
            </div>
            <div class="my-4">
                <h2 class="fw-bold my-3 fftitle codark">Qualifications</h2>
                <p class="">{{ $job->qualifications }}</p>
            </div>
            <div class="my-4">
                <h2 class="fw-bold my-3 fftitle codark">Benefits</h2>
                <p class="">{{ $job->benefits }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bglight px-5 py-4 mb-4">
                <h3 class="fw-bold my-4 fftitle codark">Job Summary</h3>
                <p class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Published On: {{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}
                </p>
                <p class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Vacancy: {{ $job->vacancies }}
                </p>
                <p class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Job Nature:
                    {{ $job->work_type == 'onsite' ? 'On Site' : ($job->work_type == 'remote' ? 'Remote' : ($job->work_type == 'hybrid' ? 'Hybrid' : 'Freelance')) }}
                </p>
                <p class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Salary: {{ $job->min_salary }} - {{ $job->max_salary }}
                </p>
                <p class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Location: {{ $job->city->name }}
                </p>
                <p class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Date Line: {{ \Carbon\Carbon::parse($job->deadline)->format('d M, Y') }}
                </p>
                <div class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Technologies:
                    <ul>
                        @foreach ($job->technologies as $tec)
                            <li> {{ $tec->name }} </li>
                        @endforeach
                    </ul>

                </div>
                <div class="my-4">
                    <i class="fa-solid fa-chevron-right coprimary me-2"></i>
                    Categories:
                    <ul>
                        @foreach ($job->categories as $cat)
                            <li> {{ $cat->name }} </li>
                        @endforeach
                    </ul>

                </div>
            </div>
            <div class="bglight px-5 py-4">
                <h3 class="fw-bold my-4 fftitle codark">Company Details</h3>
                <p class="my-4">
                    {{ $job->company->description }}
                </p>
            </div>

            <div class="row justify-content-center p-3">
                @if (isset(Auth::user()->company) && Auth::user()->company->id == $job->company_id)
                    <a href="{{ route('jobs.applications', $job) }}"
                        class="btn bgsecondary cowhite fw-bolder fs-5 my-2">View Applications</a>
                    <a href="{{ route('jobs.edit', $job) }}" class="btn bgprimary cowhite fw-bolder fs-5 my-2">Edit Job</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger my-2" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">Delete</button>
                @endif
                @if (isset(Auth::user()->candidate))
                    @if (isset($application))
                        <form class="row" action="{{ route('application.destroy', $application->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <h5 class="text-center text-success ">You have applied for this Job</h5>
                            <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                            <button type="submit" class="btn btn-danger cowhite fw-bolder fs-5 my-3">Cancel</button>
                        </form>
                    @else
                        <form class="row" action="{{ route('application.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                            <button type="submit" class="btn bgprimary cowhite fw-bolder fs-5 my-3">Apply Now</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div id="spacer" class="my-4"></div>
    <x-comment :jobid="$job->id"> </x-comment>
    @if (count($job->comments) > 0)
        <div id="spacer" class="my-3"></div>
        @foreach ($job->comments as $comment)
            <x-comment :comment="$comment"> </x-comment>
        @endforeach
    @endif
@endsection
