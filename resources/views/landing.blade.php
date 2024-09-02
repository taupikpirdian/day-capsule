<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mofi admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Mofi admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>Sirimau - Sistem Informasi dan Monitoring Kinerja Bidang Tindak Pidana Khusus Kejaksaan Tinggi Sumatera Selatan</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300;400;500;600;700;800&amp;family=Poppins:wght@200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendors/icofont.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendors/unicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/svg/landing-icons.svg') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendors/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendors/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/vendors/animate.css') }}" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="{{ asset('assets/css/vendors/bootstrap.css') }}" rel="stylesheet">
    <!-- App css-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Responsive css-->
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">

    <style>
        .f-light {
          font-size: 45px !important;
        }

        @media (max-width: 1200px) {
          .img-siap {
            width: 70%;
          }
        }

        @media (max-width: 1680px) {
          .img-siap {
            width: 30%;
            position: relative;
            left: 50%;
          }
        }

        @media (min-width: 1820px) {
          .img-siap {
            width: 30%;
            position: relative;
            left: 50%;
          }
        }
    </style>
  </head>
  <body class="landing-page">
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="landing-page">
      <!-- Page Body Start            -->
      <div class="landing-home"><span class="cursor"><span class="cursor-move-inner"><span class="cursor-inner"></span></span><span class="cursor-move-outer"><span class="cursor-outer"></span></span></span>
        <div class="paginacontainer">
          <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewbox="-1 -1 102 102">
              <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
            </svg>
          </div>
        </div>
        <div class="container-fluid">
          <div class="sticky-header">
            <header>                       
              <nav class="navbar navbar-b navbar-dark navbar-trans navbar-expand-xl fixed-top nav-padding" id="sidebar-menu">
                <a class="navbar-brand p-0" href="/"><img class="img-fluid" src="{{asset('assets/images/landing/header/logo-kejaksaan.png')}}" alt=""></a>
                <a class="navbar-brand p-0" href="/"><img class="img-fluid" src="{{asset('assets/images/landing/header/logo-pidsus.png')}}" alt=""></a>
                <a class="navbar-brand p-0" href="/"><img class="img-fluid" src="{{asset('assets/images/landing/header/logo-bumn.png')}}" alt=""></a>
                <a class="navbar-brand p-0" href="/"><img class="img-fluid" src="{{asset('assets/images/landing/header/logo-sirimau.png')}}" alt=""></a>
                <button class="navbar-toggler navabr_btn-set custom_nav" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation"><span></span><span></span><span></span></button>
                <div class="navbar-collapse justify-content-center collapse hidenav" id="navbarDefault" style="color: red">
                </div>
                @if(Auth::check())
                <div class="buy-btn"><a class="nav-link js-scroll" href="{{url('/dashboard')}}">Dashboard</a></div>
                @else
                <div class="buy-btn"><a class="nav-link js-scroll" href="{{url('login')}}">Login</a></div>
                @endif
              </nav>
            </header>
          </div>
        </div>
        <div class="home-bg" id="home" style="background-image: url({{asset('assets/images/bg/bg-landing.png')}});">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-7">
              <div class="home-text">
                <div class="main-title">
                  <div class="d-flex align-items-center gap-2">
                    <div class="flex-shrink-0"><img src="{{asset('assets/images/landing/icon/Rocket.png')}}" alt=""></div>
                    <div class="flex-grow-1">
                      <p class="m-0">Sirimau</p>
                    </div>
                  </div>
                </div>
                <h2>Selamat Datang Di Aplikasi <span>SIRIMAU</span><img class="line-text" src="../assets/images/landing/home/line.png" alt=""></h2>
                <p>Sistem Informasi dan Monitoring Kinerja Bidang Tindak Pidana Khusus Kejaksaan Tinggi Sumatera Selatan</p>
              </div>
            </div>
            <div class="col-lg-6 col-md-5">
              <div class="home-screen">
                <div class="screen-1"><img class="img-fluid" style="width: 70%" src="{{ asset('assets/images/landing/harimau.png') }}" alt=""></div>
                <div class="screen-2"><img class="img-fluid img-siap" src="{{ asset('assets/images/landing/header/logo-siap-melayani.jpg') }}" alt=""></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <section class="section-space framework-section overflow-hidden" id="frameworks">
        <div class="container">
          <div class="title">
            <h5 class="sub-title">Report Data</h5>
            <h2>Perkara</h2>
          </div>
        </div>
        <div class="container">
          <div class="col-sm-12"> 
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="html" role="tabpanel">
                <div class="row g-sm-5 gy-4">
                  {{-- <div class="col-xxl-3 col-md-6 slideInUp wow">
                    <div class="framework-box">
                      <div class="frame-icon"> <img src="../assets/images/landing/icon/html/8.png" alt=""></div>
                      <div class="frame-details">
                        <h5>Penyelidikan</h5>
                        <p class="f-light size-count">{{ $total_penyelidikan }}</p>
                      </div>
                    </div>
                  </div> --}}
                  <div class="col-xxl-12 col-md-12 slideInUp wow">
                    <div class="framework-box">
                      <div class="frame-icon"> <img src="../assets/images/landing/icon/html/8.png" alt=""></div>
                      <div class="frame-details">
                        <h5>Penyidikan</h5>
                        <p class="f-light size-count">{{ $total_penyidikan }}</p>
                      </div>
                    </div>
                  </div>
                  {{-- <div class="col-xxl-3 col-md-6 slideInUp wow"> 
                    <div class="framework-box">
                      <div class="frame-icon"> <img src="../assets/images/landing/icon/html/8.png" alt=""></div>
                      <div class="frame-details">
                        <h5>Tuntutan</h5>
                        <p class="f-light size-count">{{ $total_tuntutan }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xxl-3 col-md-6 slideInUp wow">
                    <div class="framework-box">
                      <div class="frame-icon"> <img src="../assets/images/landing/icon/html/8.png" alt=""></div>
                      <div class="frame-details">
                        <h5>Eksekusi</h5>
                        <p class="f-light size-count">{{ $total_eksekusi }}</p>
                      </div>
                    </div>
                  </div> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/cursor/stats.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/animation/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/landing_sticky.js') }}"></script>
    <script src="{{ asset('assets/js/landing.js') }}"></script>
    <script src="{{ asset('assets/js/jarallax_libs/libs.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick/slick.js') }}"></script>
    <script src="{{ asset('assets/js/landing-slick.js') }}"></script>
    <!-- Plugins JS Ends-->
  </body>
</html>