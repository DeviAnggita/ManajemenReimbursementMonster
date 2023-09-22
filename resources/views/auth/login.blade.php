<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/login22.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2023 15:59:32 GMT -->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('templateLogin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('templateLogin/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('templateLogin/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('templateLogin/css/iofrm-theme22.css') }}">

</head>

<body>
    <div class="form-body without-side">
        <div class="website-logo">
            <a href="#">
                <div class="logo">
            </a>
            <img class="logo-size" src="{{ asset('templateLogin/images/logo-ligt.svg') }}" alt="">
            {{-- <img class="img-logo" width="200" height="100" src="{{ asset('template/img/MONSTER.png') }}"> --}}
        </div>
        </a>
    </div>
    <div class="row">
        <div class="img-holder">
            <div class="bg"></div>
            <div class="info-holder">
                <img src="{{ asset('templateLogin/images/graphic3.svg') }}" alt="">
            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Login to account</h3>
                    <p>Welcome Back !</p>

                    {{-- @if ($errors->has('email_karyawan'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn-close btn-close-xs" data-bs-dismiss="alert"
                                aria-label="Close"></button>

                            {{ $errors->first('email_karyawan') }}
                        </div>
                    @endif --}}

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn-close btn-close-xs" data-bs-dismiss="alert"
                                aria-label="Close" style="padding: 0.5rem; margin: auto; display: block;"></button>

                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span><br>
                            @endforeach
                            @if (session('closeButton'))
                                <button type="button" class="btn-close btn-close-xs" data-bs-dismiss="alert"
                                    aria-label="Close" style="padding: 0.5rem; margin: auto; display: block;"></button>
                            @endif
                        </div>
                    @endif
                    <form class="user" method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" aria-describedby="emailHelp"
                                placeholder="Enter Email Address..." name="email_karyawan" id="email_karyawan" required
                                value="{{ old('email_karyawan') }}">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" placeholder="Password"
                                name="password" id="password" required>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 offset-md-0">
                                <div class="g-recaptcha" style="align-items : center;"
                                    data-sitekey="6LekafMmAAAAACf5cnROrW6n0Vnz72mDugW1cN6n"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{ asset('templateLogin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('templateLogin/js/popper.min.js') }}"></script>
    <script src="{{ asset('templateLogin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('templateLogin/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
</body>

<!-- Mirrored from brandio.io/envato/iofrm/html/login22.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2023 15:59:33 GMT -->

</html>
