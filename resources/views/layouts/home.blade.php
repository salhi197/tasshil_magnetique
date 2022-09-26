<!doctype html>
<html lang="en" dir="ltr">
    <head>
        <!-- Meta data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta content="Solic – Bootstrap Responsive Modern Simple Dashboard Clean HTML Premium Admin Template" name="description">

        <!-- CALENDAR CSS -->
        
        
        <!--favicon -->
        <link rel="icon" href="{{ asset('../../assets/images/brand/favicon.ico') }}" type="image/x-icon"/>
        <link rel="shortcut icon" href="{{ asset('../../assets/images/brand/favicon.ico') }}" type="image/x-icon"/>

        <!-- TITLE -->
        <title> TASSHIL </title>

        <!-- DASHBOARD CSS -->

        <link href="{{ asset('../../assets/css/style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('../../assets/css/style-modes.css') }}" rel="stylesheet"/>
     
        <!-- HORIZONTAL-MENU CSS -->
        <link href="{{ asset('../../assets/css/horizontal-menu.css') }}" rel="stylesheet">

        <!--C3.JS CHARTS PLUGIN -->

        <!-- TABS CSS -->
        <link href="{{ asset('../../assets/plugins/tabs/style-2.css') }}" rel="stylesheet" type="text/css">

        <!-- PERFECT SCROLL BAR CSS-->
        <link href="{{ asset('../../assets/plugins/pscrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />

        <!--- FONT-ICONS CSS -->
        <link href="{{ asset('../../assets/css/icons.css') }}" rel="stylesheet"/>

        <!-- Skin css-->
        <link href="{{ asset('../../assets/skins/skins-modes/color18.css') }}"  id="theme" rel="stylesheet" type="text/css" media="all" />

        <link href="{{ asset('css/toastr.css') }}" rel="stylesheet" />

    </head>

    <body class="default-header">


        <!-- GLOBAL-LOADER -->


        <div class="page">
            <div class="page-main">
                <!-- HEADER -->
                <div class="header hor-top-header">
                    <div class="container">
                        <div class="d-flex">
                            <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
                            <div class="col-md-2">
                                    <input class="form-control" id="input_id" placeholder="scanner :" autofocus="true" type="text"/>
                                </div> 
                            <a class="header-brand" href="/home">
                                <img src="{{ asset('../../assets/images/brand/log.png') }}" class="header-brand-img desktop-logo" alt="Solic logo">
                                <img src="{{ asset('../../assets/images/brand/logo-1.png') }}" class="header-brand-img mobile-view-logo" alt="Solic logo">
                            </a><!-- LOGO -->

                            <a class="header-brand header-brand2" href="/home">
                                <img src="{{ asset('../../assets/images/brand/log.png') }}" class="header-brand-img desktop-logo" alt="Solic logo">
                                <img src="{{ asset('../../assets/images/brand/logo-1.png') }}" class="header-brand-img mobile-view-logo" alt="Solic logo">
                            </a><!-- LOGO -->
                            <div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
                                <div class="dropdown d-md-flex">
                                    <a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
                                        <i class="fe fe-maximize-2"></i>
                                    </a>
                                </div><!-- FULL-SCREEN -->

                                <div class="dropdown d-md-flex header-settings">
                                    <a href="#" class="nav-link " data-toggle="dropdown">
                                        <span><img src="{{ asset('../../assets/images/users/male/32.ico') }}" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>
                                    </a>
                                    
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <div class="drop-heading  text-center border-bottom pb-3">
                                            <h5 class="text-dark mb-1">TASSHIL</h5>
                                            <small class="text-muted">Logiciel De Gestion de l'école</small>
                                        </div>
                                        <a class="dropdown-item" href="/home"><i class="mdi mdi-account-outline mr-2"></i> <span>My profile</span></a>

                                        <a class="dropdown-item" href="/sync"><i class="mdi mdi-account-outline mr-2"></i> <span>Synchronisation</span></a>

                                        {{-- <a class="dropdown-item" href="/lang/ar"><i class="mdi mdi-account-outline mr-2"></i> <span>Arabe</span></a> --}}
                                        <a class="dropdown-item" href="/lang/en"><i class="mdi mdi-account-outline mr-2"></i> <span>Français</span></a>

                                        <a class="dropdown-item" onclick="event.preventDefault();

                                            document.getElementById('logout-form').submit();" href="{{ url('/logout') }}"><i class="mdi mdi-logout-variant mr-2"></i> <span>Logout</span>

                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">

                                            {{ csrf_field() }}

                                        </form>

                                        {{--  --}}
                                    </div>
                                </div>
                                

                                <!-- SIDE-MENU -->
                                {{--  --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- HEADER END -->

                <!-- HORIZONTAL-MENU -->
                <div class="sticky">
                    <div class="horizontal-main hor-menu clearfix">
                        <div class="horizontal-mainwrapper container clearfix">
                            <nav class="horizontalMenu clearfix">
                                <ul class="horizontalMenu-list">
                                    
                                    <li aria-haspopup="true"><a href="/home" class="">Profile</a></li>                                    


                                    <li aria-haspopup="true"><a href="/home/classes" class=""> {{ trans('main.Salles') }}</a></li>
                                    
                                    <li aria-haspopup="true"><a href="/home/niveaux" class=""> Niveaux</a></li>
                                    
                                    <li aria-haspopup="true"><a href="/home/matiéres" class=""> Matiéres</a></li>

                                    <li aria-haspopup="true"><a href="/home/Enseignants" class=""> Enseignants</a></li>
                                    

                                    <li aria-haspopup="true">
                                        
                                        <a href="/home/groupes" class="sub-icon">
                                                Groupes 
                                            
                                        </a>
                                        
                                        <ul class="sub-menu">
                                                
                                            <li aria-haspopup="true">
                                                <a href="/home/inscriptions">Inscriptions</a>
                                            </li>

                                            <li aria-haspopup="true">
                                                <a href="/home/groupes">Groupe</a>
                                            </li>
                                            
                                            <li aria-haspopup="true">
                                                <a href="/home/groupes_special">Groupe Spécial</a>
                                            </li>

                                            {{-- <li aria-haspopup="true">
                                                <a href="/home/particuliers">Particulier</a>
                                            </li> --}}


                                            <li aria-haspopup="true">
                                                <a href="/home/calendrier">Calendrier</a>
                                            </li>

                                        </ul>
                                    </li>                                    
                                    
                                    <li aria-haspopup="true"><a href="/home/dawarat" class=""> Dawarat</a></li>
                                    
                                    <li aria-haspopup="true"><a href="/home/caisse" class="">Caisse</a></li>


                                    {{--  --}}                                        
                                </ul>
                            </nav>
                            <!-- NAV END -->
                            
                        </div>
                    </div>
                </div>
                <!-- HORIZONTAL-MENU END -->

                @if ((session()->has('notification.message')))

                    <div id="nnotif" class="alert alert-{{ session()->get('notification.type') }}" style="text-align: center;">

                        {{ session()->get('notification.message') }}
                    </div>

                  {{--  --}}
                @endif               


                <!-- CONTAINER -->
                <div class="container content-area relative">

                    @yield('content')

                </div>
                <!-- CONTAINER END -->
            </div>


            <!-- FOOTER -->
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-md-12 col-sm-12 text-center">
                            Copyright © 2021 <a href="#">TASSHIL</a> Designed by <a href="#">TASSHIL</a> All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- FOOTER END -->
        </div>

        <!-- BACK-TO-TOP -->
        <a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

        <!-- JQUERY SCRIPTS -->
        <script src="{{ asset('../../assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

        <!-- BOOTSTRAP SCRIPTS -->
        <script src="{{ asset('../../assets/js/vendors/bootstrap.bundle.min.js') }}"></script>

        <!-- SPARKLINE -->
        <script src="{{ asset('../../assets/js/vendors/jquery.sparkline.min.js') }}"></script>


        <!-- RATING STAR -->

        <!-- SELECT2 JS -->




        <!-- HORIZONTAL-MENU -->
        <script src="{{ asset('../../assets/plugins/horizontal-menu/horizontal-menu.js') }}"></script>

        <!-- PERFECT SCROLL BAR JS-->

        <!-- SIDEBAR JS -->
        <script src="{{ asset('../../assets/plugins/sidebar/sidebar.js') }}"></script>

        <!-- APEX-CHARTS JS -->


        <!-- INDEX-SCRIPTS  -->
        <script src="{{ asset('../../assets/js/index.js') }}"></script>

        <!-- STICKY JS -->
        <script src="{{ asset('../../assets/js/stiky.js') }}"></script>

        <!-- CUSTOM JS -->

        <!-- C3.JS CHART PLUGIN -->


        <!-- INPUT MASK PLUGIN-->
        <script src="{{ asset('../../assets/plugins/input-mask/jquery.mask.min.js') }}"></script>

        <!-- DATA TABLE -->
        

        <!-- SELECT2 JS -->

        <!-- STICKY JS -->

        <!-- SIDEBAR JS -->
        <script src="{{ asset('../../assets/plugins/sidebar/sidebar.js') }}"></script>

        <!-- CUSTOM JS-->
        <script src="{{ asset('../../assets/js/custom.js') }}"></script>

      

        <!-- SWEET-ALERT PLUGIN -->

        <script src="{{ asset('js/toastr.min.js') }}"></script>        



        <!-- ECHART JS -->

        <!-- ECHART PLUGIN -->
        <script>

            $(function() {
                $("#input_id").focus();
            });
            $('#input_id').on('change',function(){
            console.log('saz')
            if($('#input_id').val().length >0){
                let number = parseInt($('#input_id').val(), 10);
                /**
                 * هاد البارتي خليها نفيريفي المتركول ادا يكزيستي بجافا سكريبت قبل ما تبعتو
                 */
                let matricules = {!! json_encode(Config::get('matricules')) !!};
                var res = false;
                matricules.map(function (matricule) {
                    res = res || matricule.matricule == number;
                });                          

                console.log(res)
                if(res==false){
                    toastr.error('Carte Non valide')
                    $("#input_id").focus();
                    $('#input_id').val("")
                }else{
                    window.location.href = 'http://localhost:8000/home/scann/'+number;
                }


                // let matricules = [788];
                //console.log(matricules);
                // var res = false;
                // matricules.map(function (matricule) {
                //     res = res || matricule.matricule == number;
                // });          
                // console.log(res)
                // if(res==false){
                //     // toastr.error('Carte Non valide')
                //     $('#input_id').val("")
                // }else{
                    // window.location.href = 'http://localhost:8000/home/scann/'+number;
                // }
            }
            });

        </script>



        @yield('scripts')
    </body>
</html>


