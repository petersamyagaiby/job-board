@extends("layouts.app")

@section("content")
    <div class="col-md-8 offset-md-2 my-5">
        <div class="mb-4 bgwhite">
            <div class="m-4 py-4">
                <h1>{{ __("Login") }}</h1>
                <form method="POST" action="{{ route("login") }}">
                    @csrf

                    <div class="form-group my-4">
                        <label class="form-label" for="email">{{ __("Email Address") }}</label>
                        <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" value="{{ old("email") }}"
                            required autocomplete="email" autofocus>
                        @error("email")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group my-4">
                        <label class="form-label" for="password">{{ __("Password") }}</label>
                        <input id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error("password")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group my-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old("remember") ? "checked" : "" }}>
                            <label class="form-label" class="form-check-label" for="remember">
                                {{ __("Remember Me") }}
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn text-light bgprimary">{{ __("Login") }}</button>

                        @if (Route::has("password.request"))
                            <a class="btn btn-link" href="{{ route("password.request") }}">
                                {{ __("Forgot Your Password?") }}
                            </a>
                        @endif
                    </div>
                </form>
                <div class="d-flex justify-content-center my-3">
                    <a href="{{ route("register") }}" class="btn btn-link">Don't have an account?</a>
                </div>
            </div>
        </div>
    </div>
@endsection
