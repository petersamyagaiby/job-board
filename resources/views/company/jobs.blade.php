@extends("layouts.app")

@section("title")
    Our Jobs
@endsection

@section("content")
    <div class="py-3">
        <h1 class="text-center pt-5 fw-bolder fftitle codark">Job Listing</h1>
        @if (count($softDeletedJobs) > 0)
            <div class="d-flex justify-content-end m-3">
                <a href="{{ route("jobs.trashed") }}" class="btn bg-danger cowhite">Trashed Jobs</a>
            </div>
        @endif
        @if (count($jobs) == 0)
            <div class="text-center">
                <h2 class="codark fftitle my-4">No Jobs Available</h2>
                <h2 class="codark fftitle my-4">Want to add new job?</h2>
                <a href="{{ route("jobs.create") }}" class="btn bgprimary cowhite fs-3">Post a Job</a>
            </div>
        @else
            @foreach ($jobs as $job)
                <div class="m-5 p-4 job-item">
                    <a href="{{ route("jobs.show", $job) }}" class="text-decoration-none cogrey">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset("assets/images/company/logo.jpg") }}" width="100" height="100" style="border: 1px solid #dee2e6 !important">
                            </div>
                            <div class="col-7">
                                <h4 class="codark fftitle">{{ $job->title }}</h4>
                                <p>Company Name: {{ $job->company->company_name }}</p>
                                <span class="me-3">
                                    <i class="fa-solid fa-location-dot coprimary me-1"></i>
                                    {{ $job->city->name }}
                                </span>
                                <span class="me-3">
                                    <i class="fa-regular fa-clock coprimary me-1"></i>
                                    {{ $job->work_type == "onsite" ? "On Site" : ($job->work_type == "remote" ? "Remote" : ($job->work_type == "hybrid" ? "Hybrid" : "Freelance")) }}
                                </span>
                                <span class="me-3">
                                    <i class="fa-regular fa-money-bill-1 coprimary me-1"></i>
                                    {{ $job->min_salary }} - {{ $job->max_salary }}
                                </span>
                            </div>
                            <div class="col-3 text-end">
                                <button class="btn bgprimary cowhite m-3">View Details</button>
                                <p class="me-4">
                                    <i class="fa-solid fa-calendar-days coprimary me-1"></i>
                                    Date Line:
                                    {{ \Carbon\Carbon::parse($job->deadline)->format("d M Y") }}
                                </p>

                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection
