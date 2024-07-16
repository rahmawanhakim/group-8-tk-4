<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/jic/trifecta.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <style>
        #eye {
            display: none;
        }

        #eye:hover {
            color: maroon;
        }
    </style>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('assets/img/jic/trifecta-red.png') }}" style="width:60px;" alt="">
                            </span>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Trifecta!👋</h4>
                        <p class="mb-4">Please sign-in to your account</p>

                        @if (\Session::has('error'))
                            <div class="alert alert-danger d-flex alert-dismissible" role="alert">
                                <span
                                    class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">🙁</span>
                                <div class="d-flex flex-column ps-1">
                                    <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Oops!</h6>
                                    <span>{{ Session::get('error') }}</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                            @php \Session::forget('error') @endphp
                        @endif

                        <form id="formAuthentication" class="mb-3" action="{{ route('check-login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter your username" autofocus required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="auth-forgot-password-basic.html" class="text-muted">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="Enter your password" oninput="hiddenscript()"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer">
                                        <a class="purple-head hover-black wrapper" class="eyeicon" id="myBtn">
                                            <i class="fas fa-eye" id="eye" onclick="Showfunction()"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div> --}}
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
    <!-- / Content -->

</body>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function hiddenscript() {
        var eye = document.getElementById("eye");
        if (document.getElementById("password").value.trim().length == 0) {
            eye.style.display = "none";
        } else {
            eye.style.display = "block";
        }
    }

    function Showfunction() {
        var eye = document.getElementById("eye");
        var eye2 = document.getElementById("eye2");
        var pass = document.getElementById("password");
        var value = document.getElementById('password').value;

        if (value.length > 0) {
            eye.style.display = "block";
        }
        if (pass.type === "password") {
            pass.type = "text";
            eye.classList.toggle('fa-eye');
            eye.classList.toggle('fa-eye-slash');
        } else {
            pass.type = "password";
            eye.classList.toggle('fa-eye');
            eye.classList.toggle('fa-eye-slash');
        }
    }
</script>

</html>
