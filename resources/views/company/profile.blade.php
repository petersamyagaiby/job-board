@extends("layouts.app")

@section("content")
    <div class="row ">
        <div class="col-md-8 offset-md-2">
            <div class=" mb-4 bgwhite">
                {{-- <div class="card-header">
                    </div> --}}
                <div class="m-4 py-4 ">
                    <h1>Company Profile</h1>
                    @if ($company->logo)
                        {{-- <p>{{asset('companies/'.$company->logo)}}</p> --}}
                        <div class="text-center mb-4">

                            <img src="{{ asset("companies/" . $company->logo) }}" alt="company Picture" class="img-thumbnail rounded-circle object-fit-cover"
                                width="20%" height="20%">
                        </div>
                    @else
                        <span>No Company Logo</span>
                    @endif

                    <h4>Company Information</h4>
                    <ul class="list-group list-group-flush mb-4">
                        {{-- <p>test{{ $company->user->name }}</p> --}}
                        <li class="list-group-item bgwhite"><strong>Name:</strong> {{ $company->user->name }}</li>
                        <li class="list-group-item bgwhite"><strong>Email:</strong> {{ $company->user->email }}</li>
                        <li class="list-group-item bgwhite"><strong>Contact Number:</strong> {{ $company->contact_phone }}
                        </li>
                    </ul>

                    <h4>Company Details</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item bgwhite"><strong>Company Name:</strong> {{ $company->company_name }}</li>
                        <li class="list-group-item bgwhite"><strong>Company description:</strong>
                            {{ $company->description }}</li>

                    </ul>

                    <h4>Additional Information</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item bgwhite"><strong>Joined on:</strong>
                            {{ $company->created_at->format("M d, Y") }}</li>
                    </ul>

                    <div class="text-center">
                        <a href="{{ route("company.edit", $company) }}" class="btn text-light bgprimary me-3">Edit Profile</a>

                        <a href="{{ route("company.destroy", $company) }}" class="btn btn-danger"
                            onclick="event.preventDefault(); if(confirm('Are you sure you want to delete your profile?')){ document.getElementById('delete-form').submit(); }">
                            Delete profile
                        </a>
                        <form id="delete-form" action="{{ route("company.destroy", $company) }}" method="POST" style="display: none;">
                            @csrf
                            @method("DELETE")
                        </form>
                        {{-- <form id="delete-form" action="{{ route('company.destroy', $company ) }}" method="POST">
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
