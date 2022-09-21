<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Webpixels">
    <title>TASSHIL | Logiciel de Gestion des écoles</title>
    <!-- Preloader -->
    <style>
        @keyframes hidePreloader 
        {
            0% 
            {
                width: 100%;
                height: 100%;
            }

            100% 
            {
                width: 0;
                height: 0;
            }
        }

        body>div.preloader {
            position: fixed;
            background: white;
            width: 100%;
            height: 100%;
            z-index: 1071;
            opacity: 0;
            transition: opacity .5s ease;
            overflow: hidden;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body:not(.loaded)>div.preloader {
            opacity: 1;
        }

        body:not(.loaded) {
            overflow: hidden;
        }

        body.loaded>div.preloader {
            animation: hidePreloader .5s linear .5s forwards;
        }
    </style>
    <script>
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.querySelector('body').classList.add('loaded');
            }, 300);
        });
    </script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('Welcome/assets/img/brand/favicon.png') }}" type="image/png">
    
    <link rel="stylesheet" href="{{ asset('Welcome/assets/libs/@fortawesome/fontawesome-free/css/all.min.css')}}">
    <!-- Quick CSS -->
    <link rel="stylesheet" href="{{ asset('Welcome/assets/css/quick-website.css') }}" id="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="/">
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                
                <ul class="navbar-nav mt-4 mt-lg-0 ml-auto">

                    <li class="nav-item ">
                        <a class="nav-link" href="#">0557015468 / 0794498727</a>
                    </li>
                    <li class="nav-item badge badge-primary " >
                        <a class="nav-link text-white" href="/home">تجربة البرنامج</a>
                    </li>
                    <li class="nav-item text-primary" >
                        
                        <a class="nav-link " href="https://web.facebook.com/tasshildz"><i class="fa fa-facebook " style="color:blue"> </i></a>
                    </li>

                </ul>

                <!--  -->
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <section class="slice py-7">
        <div class="container">
            <div class="row row-grid align-items-center">
                <div class="col-12 col-md-7 col-lg-6 order-md-1 pr-md-5">
                    <!-- Heading -->
                    <h3 class="display-4 text-right text-md-left mb-3">
                    🏫 برنامج Tasshil  
                    <br>
                    لادارة‍ المدارس الخاصة والمراكز التدريبية والتعليمية وروض الأطفال 
                    </h3>
                    <!-- Text -->
                    <p class="lead text-center text-md-left text-muted">
                        امكانية تحميل البرنامج و تجربته لمدة ثلاثين يوم كاملة 
                    </p>
                    <!-- Buttons -->
                    <div class="text-center text-md-left mt-5">
                        <a href="/home" class="btn btn-primary btn-icon">
                            <span class="btn-inner--text">تجربة البرنامج اونلاين </span>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-lg-6 order-md-2 text-center">
                    <!-- Image -->
                    <figure class="w-100">
                        <img alt="Image placeholder" src="Welcome/assets/img/svg/illustrations/illustration-1.svg" class="img-fluid mw-md-120">
                    </figure>
                </div>
            </div>
        </div>
    </section>

<!--     <section class="slice pt-0">
        <div class="container position-relative zindex-100">
            <div class="row">
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="d-flex p-5">
                            <div>
                                <span class="badge badge-warning badge-pill">New</span>
                            </div>
                            <div class="pl-4">
                                <h5 class="lh-130">Listen to the nature</h5>
                                <p class="text-muted mb-0">
                                    Design made simple with a clean and smart HTML markup.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="d-flex p-5">
                            <div>
                                <span class="badge badge-success badge-pill">Tips</span>
                            </div>
                            <div class="pl-4">
                                <h5 class="lh-130">Rules not to follow</h5>
                                <p class="text-muted mb-0">
                                    Design made simple with a clean and smart HTML markup.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-sm-6">
                    <div class="card">
                        <div class="d-flex p-5">
                            <div>
                                <span class="badge badge-danger badge-pill">Update</span>
                            </div>
                            <div class="pl-3">
                                <h5 class="lh-130">Beware the water</h5>
                                <p class="text-muted mb-0">
                                    Design made simple with a clean and smart HTML markup.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Core JS  -->
    <script src="{{ asset('Welcome/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('Welcome/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Welcome/assets/libs/svg-injector/dist/svg-injector.min.js') }}"></script>
    <script src="{{ asset('Welcome/assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <!-- Quick JS -->
    <script src="{{ asset('Welcome/assets/js/quick-website.js') }}"></script>
    <!-- Feather Icons -->
    <script>
        feather.replace({
            'width': '1em',
            'height': '1em'
        })
$(function() {
  $('#mylist li a').hover(function() {
    $('#rotateImg').toggleClass('rotate');
  });
});        
    </script>
</body>

</html>
