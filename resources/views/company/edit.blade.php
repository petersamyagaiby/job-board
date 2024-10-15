@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-4 bgwhite">
                {{-- <div class="card-header">
                    </div> --}}
                <div class="m-4 py-4">
                    <h1>Edit Copmany Profile</h1>
                    <form action="{{ route('company.update', $company) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Name </label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name', $company->user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email </label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="name" value="{{ old('email', $company->user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_phone">Contact Phone</label>
                            <input type="text" name="contact_phone"
                                class="form-control  @error('contact_phone') is-invalid @enderror" id="contact_phone"
                                value="{{ old('contact_phone', $company->contact_phone) }}" required>
                            @error('contact_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <input type="text" name="description"
                                class="form-control  @error('description') is-invalid @enderror" id="description"
                                value="{{ old('description', $company->description) }}" required>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            @if ($company->logo)
                                <p>Current logo:
                                    <img src="{{ asset('companies/' . $company->logo) }}" alt="company logo"
                                        class="img-thumbnail rounded-circle object-fit-cover" width="20%" height="20%">
                                </p>
                            @endif
                            <label for="logo">Upload logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                id="logo" accept=".png,.jpg,.jpeg,.gif">
                            {{-- <small class="text-muted">Leave blank if you don't want to change the logo.</small> --}}
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn  text-light bgprimary">Update Profile</button>
                            <a href="{{ route('company.profile') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
