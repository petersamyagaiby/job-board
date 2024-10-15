@extends("layouts.app")

@section("title")
    All Jobs
@endsection
@section("content")
    <div>
        <form action="{{ route("jobs.filter") }}" class="w-100 d-flex mt-5 px-5" method="GET">
            <div class="col-md-5">
                <input type="text" name="keywords" id="keywords" placeholder="Keyword (Job Title, Technology, Work type, ...)" class="form-control"
                    style="width: 100%;">
            </div>

            <div class="col-md-1">
                <input type="number" name="min_salary" class="form-control" placeholder="Min" step="1000" style="width: 100%;">
            </div>

            <div class="col-md-1">
                <input type="number" name="max_salary" class="form-control" placeholder="Max" step="1000" style="width: 100%;">
            </div>
            <div class="col-md-2">
                <select name="city_id" class="form-control" style="width: 100%;">
                    <option value="">Select Location</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="category" class="form-control" style="width: 100%;">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class=" w-25 btn text-light bgprimary">Search</button>

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
                                    {{-- <p>{{ \Illuminate\Support\Str::words($job->description, 10) }}</p> --}}
                                    {{-- <h4>descripttion: {{ strlen($job->description) > 50 ? substr($job->description, 0, 100) . ".." : $job->description }}</h4> --}}
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
                <div class="pagination">
                    {{ $jobs->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection
