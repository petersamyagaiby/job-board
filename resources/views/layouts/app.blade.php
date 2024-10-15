<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield("title")</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">

    <!-- Scripts -->
    @vite(["resources/sass/app.scss", "resources/js/app.js"])
    @vite(["resources/sass/app.scss", "resources/js/app.js"])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100 bglight">
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white shadow-sm fftitle p-0 ">
            <div class="container">
                <a class="navbar-brand my-2" href="{{ route("homepage") }}">
                    <img src="{{ asset("assets/" . "logo.jpg") }}" class="img-thumbnail rounded-circle object-fit-cover" style="height: 50px;" alt="Job-Board">
                </a>
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link @if (Route::currentRouteName() === "homepage") coprimary fw-semibold @elseif (Route::currentRouteName() === "jobs.index") coprimary fw-semibold @endif "
                            href="{{ route("homepage") }}">Explore Jobs</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __("Toggle navigation") }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @if (isset(Auth::user()->company))
                                <li class="nav-item ">
                                    <a class="nav-link @if (Route::currentRouteName() === "company.jobs") coprimary fw-semibold @elseif (Route::currentRouteName() === "jobs.trashed") coprimary fw-semibold @endif "
                                        id="myJobs" href="{{ route("company.jobs") }}">My Jobs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (Route::currentRouteName() === "jobs.create") coprimary fw-semibold @endif  " id="postJob"
                                        href="{{ route("jobs.create") }}">Post a Job</a>
                                </li>
                            @endif

                            @guest
                                @if (Route::has("login"))
                                    <li class="nav-item">
                                        <a class="nav-link @if (Route::currentRouteName() === "login") coprimary fw-semibold @endif "
                                            href="{{ route("login") }}">{{ __("Login") }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route("logout") }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __("Logout") }}
                                        </a>

                                        <form id="logout-form" action="{{ route("logout") }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>

                        <ul class="navbar-nav">
                            <li class="nav-item bgprimary ms-2  align-content-center px-3 py-3">
                                @if (Auth::check())
                                    @if (isset(Auth::user()->company))
                                        <a class="nav-link text-light " href="{{ route("company.profile") }}">Profile</a>
                                    @elseif (isset(Auth::user()->candidate))
                                        <a class="nav-link text-light " href="{{ route("candidate.profile") }}">Profile</a>
                                    @endif
                                @else
                                    @if (Route::has("register"))
                                        <a class="nav-link text-light @if (Route::currentRouteName() === "register") fw-semibold @endif"
                                            href="{{ route("register") }}">{{ __("Register") }}</a>
                                    @endif
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container bgwhite flex-grow-1">
            @yield("content")
        </main>

        <footer class="container bgdark colight py-4">
            <div class="row pt-5 colightopacity">
                <div class="col">
                    <ul style="list-style-type:none;" class="">
                        <li>
                            <h5 class="fw-bold colight">Where to find us</h5>
                        </li>

                        <li>
                            &#10148; <a href="/" class="link-underline-opacity-0  link-light link-opacity-50">28
                                Gardenia St</a>
                        </li>
                        <li>
                            &#10148; <a href="/" class="link-underline-opacity-0  link-light link-opacity-50">London, UK</a>
                        </li>
                        <li>
                            &#10148; <a href="/" class="link-underline-opacity-0  link-light link-opacity-50">Show
                                Map</a>
                        </li>
                    </ul>
                </div>

                <div class="col">
                    <ul style="list-style-type:none;" class="">
                        <li>
                            <h5 class="fw-bold colight">How To Contact Us</h5>
                        </li>

                        <li>
                            &#10148; <a href="/" class="link-underline-opacity-0 link-light link-opacity-50 ">Tel:
                                +963 7546231</a>
                        </li>
                        <li>
                            &#10148; <a href="/" class="link-underline-opacity-0 link-light link-opacity-50 ">Fax: +963 7546231</a>
                        </li>
                        <li>
                            &#10148; <a href="/" class="link-underline-opacity-0 link-light link-opacity-50 ">Email:
                                info@jobboard.or.uk</a>
                        </li>
                    </ul>
                </div>

            </div>
            <hr>
            <div class="row">

                <div class="col flex-grow mx-4 fw-medium">
                    <span class="colightopacity"> &#169; </span> Job Board <span class="colightopacity">All Rights Reserved</span>
                </div>
                <div class="col-auto mx-4 fw-medium">
                    <div class="row justify-content-between">
                        <a href="#" class="col-auto link-underline link-underline-opacity-0 colightopacity">
                            <i class="fa-brands fa-facebook"></i>
                        </a>

                        <a href="#" class="col-auto link-underline link-underline-opacity-0 colightopacity">
                            <i class="fa-brands fa-square-instagram"></i>
                        </a>

                        <a href="#" class="col-auto link-underline link-underline-opacity-0 colightopacity">
                            <i class="fa-brands fa-square-x-twitter"></i>
                        </a>

                        <a href="#" class="col-auto link-underline link-underline-opacity-0 colightopacity">
                            <i class="fa-brands fa-youtube"></i>
                        </a>

                        <a href="#" class="col-auto link-underline link-underline-opacity-0 colightopacity">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "3000"
        };

        @if (session("success"))
            toastr.success("{{ session("success") }}");
        @endif

        @if (session("error"))
            toastr.error("{{ session("error") }}");
        @endif
    </script>
</body>

</html>
