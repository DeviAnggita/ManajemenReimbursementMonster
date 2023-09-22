<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('dashboard/images/LogoMonster.png') }}">
    <title>About | Reimbursement</title>
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
                                            <img src="{{ asset('dashboard/images/aboutNew.png') }}" alt=""
                                                style="max-width: 50%; height: auto;">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="b-text">About Us</div>
                                        <div class="page-subtitle">We Believe Innovative Technology Will Create Impacts
                                            for Lifelong Success </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="text-photo-sc container-fluid darkblue-bg">
        <div class="row">
            <div class="col-md-6 photo-holder photo1"></div>
            <div class="col-md-6 text-holder text1">
                <div class="text-box">
                    <h4>Who We Are</h4>
                    <p>Monster Group is a leading technology-based corporate group that was established in 2011.
                        Starting as a Telco Service Provider, our business segmentation expands to HR Service Solutions,
                        IT 360 Solutions, and Creative Powerhouse. Headquartered in Indonesia, Monster Group now employs
                        over 300 professionals across the subsidiaries. In addition to our Ciputat head office, our
                        company has other seven branch offices across the country. Our company also goes global with
                        four branch offices in Singapore, Vietnam, and the US.
                    </p>
                    <p>
                        The heart of our innovation is come from our drive to adapt to the rapidly changing technology
                        and lifestyle. This enables our company to improve our innovations and deliver clients the best
                        services and products. We hold firm our vision to always present the game-changing output as a
                        manifestation of our stance as the key player in the technology industry in the region.</p>
                </div>
            </div>
        </div>
    </div>



    <div class="text-photo-sc container-fluid darkblue-bg">
        <div class="row rtl-row">
            <div class="col-md-6 photo-holder photo1"></div>
            <div class="col-md-6 text-holder text2 opposite">
                <div class="text-box">
                    <h4>Our Mission</h4>
                    <p>- Become the best game-changer in the region.</p>
                    <p>- Become role model for enhancing competitive advantages.</p>
                    <p>- Always present the most valuable output to the region, community & employees.</p>
                    <p>- Become the center of education & knowledge to all stakeholders.</p>
                    <p>- Develop future leader with an excellent character.</p>
                    <p>- Give opportunities to all employees to be key part of our great success.</p>
                </div>
            </div>
        </div>
    </div>






    <div class="services container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row-title">Our Companies</div>
                    <div class="row-subtitle">Monster Group exists to support the growth of our entire company. Learn
                        more about our subsidiary companies here.</div>
                </div>
            </div>
            <div class="row custom-padding">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a href="#" class="service-box">
                        <div class="title">Triple One Global</div>
                        <div class="icon"><img src="{{ asset('dashboard/images/server1.svg') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a href="#" class="service-box">
                        <div class="title">TOG Indonesia</div>
                        <div class="icon"><img src="{{ asset('dashboard/images/server4.svg') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a href="#" class="service-box">
                        <div class="title">Monster AR</div>
                        <div class="icon"><img src="{{ asset('dashboard/images/server2.svg') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a href="#" class="service-box">
                        <div class="title">Monster MAC</div>
                        <div class="icon"><img src="{{ asset('dashboard/images/server3.svg') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a href="#" class="service-box">
                        <div class="title">Monster Code</div>
                        <div class="icon"><img src="{{ asset('dashboard/images/server5.svg') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <a href="#" class="service-box">
                        <div class="title">Monster Pro</div>
                        <div class="icon"><img src="{{ asset('dashboard/images/server6.svg') }}" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>






    <div class="support-links container-fluid">
        <div class="row">
            <div class="col-sm-6 hylink-holder">
                <div class="hylink-box">
                    <div class="icon"><img src="{{ asset('dashboard/images/info.svg') }}" alt=""></div>
                    <a href="#" style="font-weight: bold;">Let’s talk</a>
                    <div class="text">We are a leading company in the industry, specializing in providing innovative
                        solutions for businesses.</div>
                </div>
            </div>
            <div class="col-sm-6 hylink-holder">
                <div class="hylink-box">
                    <div class="icon"><img src="{{ asset('dashboard/images/chat.svg') }}" alt=""></div>
                    <a href="#" style="font-weight: bold;">Go to support center</a>
                    <div class="text">We are here to provide you with assistance and address any inquiries you may
                        have.</div>
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
