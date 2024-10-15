@extends("layouts.app")

@section("title")
    All Jobs
@endsection

@section("content")
    <div class="py-3">
        <h1 class="text-center pt-5 fw-bolder fftitle codark">Job Listing</h1>
        <div>
            <form action="{{ route("jobs.filter") }}" class="w-100 mt-3 px-5" method="GET">
                <div class="row mb-2">
                    <div class="col-md-4 ">
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 ">
                        <select name="technology" class="form-control">
                            <option value="">Select Technology</option>
                            @foreach ($technologies as $technology)
                                <option value="{{ $technology->id }}">{{ $technology->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 ">
                        <select name="city_id" class="form-control">
                            <option value="">Select Location</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row col-mb-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="keywords" id="keywords" placeholder="Keyword (Job Title, Technology, Work type, ...)" class="form-control">
                    </div>

                    <div class="col-md-2 ">
                        <input type="number" name="min_salary" class="form-control" placeholder="Min Salary" step="1000">
                    </div>

                    <div class="col-md-2 ">
                        <input type="number" name="max_salary" class="form-control" placeholder="Max Salary" step="1000">
                    </div>
                    <div class="col-md-4 ">
                        <button type="submit" class="btn text-light bgprimary w-100">Search</button>
                    </div>
                </div>
            </form>

            @if (isset($jobs))
                @if ($jobs->isEmpty())
                    <div class="position-absolute top-50 start-50 translate-middle ">
                        No jobs found.
                    </div>
                @else
                    @foreach ($jobs as $job)
                        {{-- same componet --}}
                        <div class="m-5 p-4 job-item">
                            <a href="{{ route("jobs.show", $job) }}" class="text-decoration-none cogrey">
                                <div class="row">
                                    <div class="col-2">
                                        <img src="{{ asset("assets/images/company/logo.jpg") }}" width="100" height="100"
                                            style="border: 1px solid #dee2e6 !important">
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
                                            {{ $job->work_type }}
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

                    <div class="row d-flex justify-content-md-center mx-5 p">
                        {{ $jobs->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
@endsection
