@extends("layouts.app")

@section("content")
    <div class="row mt-0 ">
        <div class="col-md-8 offset-md-2 ">
            <div class=" mb-4 bgwhite">
                {{-- <div class="card-header">
                    </div> --}}
                <div class="m-4 py-4 ">
                    <h1 class="fftitle ">Candidate Profile</h1>

                    <h4>Personal Information</h4>
                    <ul class="list-group list-group-flush mb-4">
                        {{-- <p>testing: {{ $candidate->user->name }}</p> --}}
                        <li class="list-group-item bgwhite"><strong>Name:</strong> {{ $candidate->user->name }}</li>
                        <li class="list-group-item bgwhite"><strong>Email:</strong> {{ $candidate->user->email }}</li>
                        <li class="list-group-item bgwhite"><strong>Phone Number:</strong> {{ $candidate->phone_number }}</li>
                    </ul>

                    <h4>Job Details</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item bglightopacity"><strong>Job Title:</strong> {{ $candidate->job_title }}</li>
                        <li class="list-group-item bglightopacity"><strong>CV:</strong>
                            @if ($candidate->cv)
                                <a href="{{ asset("candidates/" . $candidate->cv) }}" target="_blank" class="btn bgprimary cowhite ms-2 mt-1">View CV</a>
                            @else
                                <span>No CV uploaded</span>
                            @endif
                        </li>
                    </ul>

                    <h4>Additional Information</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item bglightopacity"><strong>Joined on:</strong>
                            {{ $candidate->created_at->format("M d, Y") }}</li>
                    </ul>

                    <div class="text-center">
                        <a href="{{ route("candidate.edit", $candidate) }}" class="btn text-light bgprimary ">Edit Profile</a>

                        <a href="{{ route("candidate.destroy", $candidate) }}" class="btn btn-danger mx-3"
                            onclick="event.preventDefault(); if(confirm('Are you sure you want to delete your profile?')){ document.getElementById('delete-form').submit(); }">
                            Delete profile
                        </a>
                        <form id="delete-form" action="{{ route("candidate.destroy", $candidate) }}" method="POST" style="display: none;">
                            @csrf
                            @method("DELETE")
                        </form>
                        {{-- <form id="delete-form" action="{{ route('candidate.destroy', $candidate ) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your profile?')">Delete profile</button>
                            </form> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
