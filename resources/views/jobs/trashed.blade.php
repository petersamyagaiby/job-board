@extends("layouts.app")

@section("title")
    Soft Deleted Jobs
@endsection

@section("content")
    <div class="py-3">
        <h1 class="text-center pt-5 fw-bolder fftitle codark">Deleted Jobs</h1>

        <div class="d-flex justify-content-end m-3">
            <a href="{{ route("jobs.index") }}" class="btn bgprimary cowhite fw-bolder fs-4">All Jobs</a>
        </div>

        @foreach ($softDeletedJobs as $job)
            <div class="m-5 p-4 trashed-jobs-item">
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
                        <form action="{{ route("jobs.forceDelete", $job->id) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <a class="btn bgprimary cowhite me-2" href="{{ route("jobs.restore", $job->id) }}">Restore</a>
                            <input type="submit" class="btn bg-danger cowhite me-2 my-3" value="Delete">
                        </form>

                        <p class="me-3">
                            <i class="fa-solid fa-calendar-days coprimary me-1"></i>
                            Date Line:
                            {{ \Carbon\Carbon::parse($job->deadline)->format("d M Y") }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
