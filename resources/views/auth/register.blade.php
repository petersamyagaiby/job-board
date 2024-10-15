@extends("layouts.app")

@section("content")
    <div class="col-md-8 offset-md-2 my-5">
        <div class="mb-4 bgwhite">
            <div class="m-4 py-4">
                <h1>{{ __("Register") }}</h1>
                <form method="POST" action="{{ route("register") }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group my-4">
                        <label class="form-label" for="name">{{ __("Name") }}</label>
                        <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" name="name" value="{{ old("name") }}"
                            required autocomplete="name" autofocus>
                        @error("name")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="email">{{ __("Email Address") }}</label>

                        <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" value="{{ old("email") }}"
                            required autocomplete="email">
                        @error("email")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="password">{{ __("Password") }}</label>
                        <input id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" required
                            autocomplete="new-password">
                        @error("password")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="password-confirm">{{ __("Confirm Password") }}</label>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="type">Register As</label>

                        <select id="type" name="type" class="form-control" required onchange="getRespectiveFields()">
                            <option selected disabled>Select Type</option>
                            <option {{ old("type") == "candidate" ? "selected" : "" }} value="candidate">Candidate</option>
                            <option {{ old("type") == "company" ? "selected" : "" }} value="company">Company</option>
                        </select>
                        @error("type")
                            <span>{{ $message }}</span>
                        @enderror

                    </div>

                    <div id="candidate-fields" style="display: none;">
                        <div class="form-group my-4">
                            <label class="form-label" for="phone_number">Phone Number</label>
                            <input id="phone_number" type="tel" class="form-control @error("phone_number") is-invalid @enderror" name="phone_number"
                                pattern="^01(0|1|2|5)[0-9]{8}$" value="{{ old("phone_number") }}">
                            @error("phone_number")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group my-4">
                            <label class="form-label" for="job_title">Job Title</label>

                            <input id="job_title" type="text" class="form-control @error("job_title") is-invalid @enderror" name="job_title"
                                value="{{ old("job_title") }}">
                            @error("job_title")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group my-4">
                            <label class="form-label" for="cv">CV</label>

                            <input id="cv" type="file" class="form-control @error("cv") is-invalid @enderror" name="cv" accept=".pdf,.doc,.docx">
                            @error("cv")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div id="company-fields" style="display: none;">
                        <div class="form-group my-4">
                            <label class="form-label" for="company_name">Company Name</label>

                            <input id="company_name" type="text" class="form-control @error("company_name") is-invalid @enderror" name="company_name"
                                value="{{ old("company_name") }}">

                            @error("company_name")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="form-group my-4">
                            <label class="form-label" for="description">Description</label>
                            <input id="description" type="text" class="form-control  @error("description") is-invalid @enderror" name="description"
                                value="{{ old("description") }}">
                            @error("description")
                                <span class="invalid-feedback" role="alert">

                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-4">
                            <label class="form-label" for="contact_phone">Contact Phone</label>
                            <input id="contact_phone" type="tel" class="form-control  @error("contact_phone") is-invalid @enderror" name="contact_phone"
                                pattern="^[0-9]{10,15}$" value="{{ old("contact_phone") }}">
                            @error("contact_phone")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-4">
                            <label class="form-label" for="logo">Logo</label>
                            <input id="logo" type="file" class="form-control  @error("logo") is-invalid @enderror" name="logo"
                                accept=".png,.jpg,.jpeg,.gif">
                            @error("logo")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        <button type="submit" class="btn text-light bgprimary ">
                            {{ __("Register") }}
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mt-3">Already have an account? <a href="{{ route("login") }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getRespectiveFields() {
            var userType = document.getElementById('type').value;
            var candidateFields = document.getElementById('candidate-fields');
            var companyFields = document.getElementById('company-fields');

            if (userType === 'candidate') {
                candidateFields.style.display = 'block';
                companyFields.style.display = 'none';
            } else if (userType === 'company') {
                candidateFields.style.display = 'none';
                companyFields.style.display = 'block';
            } else {
                candidateFields.style.display = 'none';
                companyFields.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            getRespectiveFields();
        });
    </script>
@endsection
