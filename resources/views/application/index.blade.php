@extends("layouts.app")

@section("title")
    All Jobs
@endsection

@section("content")
{{-- @if () --}}
    
{{-- @endif --}}
    <div class="py-3">
        <h1 class="text-center pt-5 fw-bolder fftitle codark">Applications for this post</h1>
        <div class="d-flex justify-content-end my-3">
            <a href="{{ route("jobs.index") }}" class="btn bgprimary cowhite fw-bolder fs-4 mx-3">Back</a>
        </div>
        @if (count($applications) > 0)
            @foreach ($applications as $application)
                <div class="m-5 p-4 application-item">
                    <div class="row">
                        <div class="col">
                            <h4 class="codark fftitle"><strong>Job Title:</strong> {{ $application->jobPost->title }}</h4>
                            <p><strong>Company Name:</strong> {{ $application->jobPost->company->company_name }}</p>
                            <p class="me-3">
                                <strong>Candidate Name:</strong> {{ $application->candidate->user->name }}
                            </p>
                            <p class="me-3">
                                <strong>Candidate CV:</strong>
                                <a target="_blank" href="{{ asset("candidates/" . $application->candidate->cv) }}" class="btn bgprimary cowhite mb-2">Download
                                    CV</a>
                            </p>
                            <p class="me-3">
                                <strong>Status:</strong>
                                {{ Str::ucfirst($application->status) }}
                            </p>
                            @if ($application->status == "rejected")
                                <p class="me-3">
                                    <strong>Rejected On:</strong>
                                    {{ \Carbon\Carbon::parse($application->accepted_at)->format("d M, Y") }}
                                </p>
                                <a href="{{ route("application.accept", $application->id) }}" class="btn bgprimary cowhite me-4">Accept Application</a>
                                <a href="{{ route("application.review", $application->id) }}" class="btn btn-info cowhite me-4">Review Application</a>
                            @elseif ($application->status == "accepted")
                                <p class="me-3">
                                    <strong>Accepted On:</strong>
                                    {{ \Carbon\Carbon::parse($application->accepted_at)->format("d M, Y") }}
                                </p>
                                <a href="{{ route("application.review", $application->id) }}" class="btn btn-info cowhite me-4">Review Application</a>
                                <a href="{{ route("application.reject", $application->id) }}" class="btn btn-danger me-4">Reject Application</a>
                            @elseif ($application->status == "reviewed")
                                <a href="{{ route("application.accept", $application->id) }}" class="btn bgprimary cowhite me-4">Accept Application</a>
                                <a href="{{ route("application.reject", $application->id) }}" class="btn btn-danger me-4">Reject Application</a>
                            @else
                                <a href="{{ route("application.accept", $application->id) }}" class="btn bgprimary cowhite me-4">Accept Application</a>
                                <a href="{{ route("application.review", $application->id) }}" class="btn btn-info cowhite me-4">Review Application</a>
                                <a href="{{ route("application.reject", $application->id) }}" class="btn btn-danger me-4">Reject Application</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h2 class="text-center pt-5 fw-bolder fftitle codark">No Applications Found</h2>
        @endif
    </div>
@endsection
