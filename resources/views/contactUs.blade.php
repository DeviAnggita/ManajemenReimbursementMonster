<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/hustbee/html/blog.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2023 15:56:28 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('dashboard/images/LogoMonster.png') }}">
    <title>Contact | Reimbursement</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/custom.css') }}">
</head>

<body>
    <div id="header-holder">
        <div class="cloud-bg"></div>
        <nav id="nav" class="navbar navbar-full" style="margin-bottom: 5px; margin-top: 0px; padding-top: 0px;">
            <div class="container" style="margin-top: 0; padding-top: 0;">
                <div class="container container-nav">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="navbar-header">
                                <button aria-expanded="false" type="button" class="navbar-toggle collapsed"
                                    data-toggle="collapse" data-target="#bs">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#"><img
                                        src="{{ asset('dashboard/images/MonsterGrup.png') }}"></a>
                            </div>
                            <div style="height: 1px;" role="main" aria-expanded="false"
                                class="navbar-collapse collapse navbar-collapse-centered" id="bs">
                                <ul class="nav navbar-nav navbar-nav-centered">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/services">Services</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="/contact-us">Contact Us</a>
                                    </li> --}}
                                    <li class="nav-item d-flex justify-content-center">
                                        <a class="nav-link" href="/login" style="color: yellow;">Login</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div id="top-content" class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
            <div class="container" style="margin-top: 0; padding-top: 0;">
                <div class="row" style="margin-top: 0px; margin-bottom: 0px;">
                    <div class="col-sm-12">
                        <div class="main-slider">
                            <div class="slide">
                                <div class="row rtl-row">
                                    <div class="col-sm-6">
                                        <div class="img-holder">
                                            <img src="{{ asset('dashboard/images/blog.png') }}" alt=""
                                                style="max-width: 50%; height: auto;">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="b-text">Contact</div>
                                        <div class="page-subtitle">We enable you to achieve more in the world of Tech.
                                            Take the next step in your business journey today! </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="contact" class="section section--contact">
        <div class="container relative mx-auto px-5 py-20 max-w-full md:max-w-screen-2xl xl:px-32">


            <div class="section-body">
                <div class="flex flex-col gap-24 md:flex-row">
                    <div class="flex-item flex-1">
                        <form id="get-in-touch" class="form" method="POST"
                            enctype="application/x-www-form-urlencoded">
                            @csrf
                            <!-- Add CSRF token for Laravel forms -->
                            <br>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" name="fullname" id="fullname" class="form-control"
                                            autocomplete="off" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            autocomplete="off" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company">Company Name</label>
                                        <input type="text" id="company" name="company" class="form-control"
                                            autocomplete="off" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            autocomplete="off" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message">Tell Us Something</label>
                                        <textarea rows="8" id="message" name="message" class="form-control" autocomplete="off" placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>





    <div class="footer container-fluid">
        <a class="btn-go-top" href="#"><i class="hstb hstb-down-arrow"></i></a>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <div class="footer-menu custom-footer-menu">
                        <h4>Contact us</h4>
                        <ul class="social">
                            <li><a href="https://monstergroup.co.id/en"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="https://www.instagram.com/monstergroup.co.id/"><i
                                        class="fab fa-instagram"></i></a></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="sub-footer">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="copyright">MonsterGroup 2023, © 2023. All rights reserved</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('dashboard/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/slick.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
</body>


</html>
