
<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Solic – Bootstrap Responsive Modern Simple Dashboard Clean HTML Premium Admin Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin dashboard template, admin panel template, bootstrap 4 admin template, bootstrap 4 dashboard, bootstrap admin, bootstrap admin panel, admin template, bootstrap admin template, dashboard template, bootstrap admin template, premium admin templates, html admin template, ecommerce dashboard, admin panel template, bootstrap admin theme, bootstrap admin panel"  />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

		<!--favicon -->
		<link rel="icon" href="../../assets/images/brand/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="../../assets/images/brand/favicon.ico" type="image/x-icon"/>

		<!-- TITLE -->
		<title>Synchronistaion</title>

		<!--- COUNT-DOWN CSS -->
		<link rel="stylesheet" href="../../assets/fonts/fonts/font-awesome.min.css">
		<link href="../../assets/plugins/count-down/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<link href="../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
		<link href="../../assets/plugins/count-down/flipclock.css" rel="stylesheet" />
		<link href="../../assets/plugins/jquery-countdown/jquery.countdown.css" rel="stylesheet" type="text/css">

		<!-- DASHBOARD CSS -->
		<link href="../../assets/css/style.css" rel="stylesheet"/>
		<link href="../../assets/css/dashboard-dark.css" rel="stylesheet"/>
		<link href="../../assets/css/style-modes.css" rel="stylesheet"/>

		<!-- HORIZONTAL-MENU CSS -->
		<link href="../../assets/css/horizontal-menu.css" rel="stylesheet">

		<!--- FONT-ICONS CSS -->
		<link href="../../assets/css/icons.css" rel="stylesheet"/>

		<!-- Skin css-->
		<link href="../../assets/skins/skins-modes/color1.css"  id="theme" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('../../assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

	</head>

	<body class="default-header">

		<div class="login-img">

		    <!-- GLOBAL-LOADER -->
			<div id="global-loader">
				<img src="../../assets/images/svgs/loader.svg" class="loader-img" alt="Loader">
			</div>

			<div class="page">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="container mt-10">
						<div class="row text-center mx-auto">
							<div class="col-lg-8 col-sm-12 center-block align-items-center construction  ">
								<div class="text-dark">
									<div class="card-body">
										<h2 class="display-2 mb-0 "><strong> System de Synchronistaion </strong></h2>
										<div class="countdown-timer-wrapper">
											
										</div>
										<p class="">
                                            Assurer La connexion de system à la base des données 
                                        </p>
										<div id="progress" class="progress progress-md mb-3 d-none"> <div class="progress-bar progress-bar-indeterminate bg-blue-1"></div> </div>

										<div class="mt-5">
											<button id="sync" class="btn  btn-primary" type="button" id="sync">
                                                Synchroniser
											</button>
										</div>
										<br>
										<div class="alert alert-success d-none" id="success-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Synchronistaion Terminé!</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
		</div>

		<!--/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/-->

		<!-- JQUERY SCRIPTS -->
		<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>

		<!-- SPARKLINE -->
		<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>

		<!-- CHART-CIRCLE -->
		<script src="../../assets/js/vendors/circle-progress.min.js"></script>

		<!-- RATING STAR -->
		<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>

		<!-- SELECT2 JS -->
		<script src="../../assets/plugins/select2/select2.full.min.js"></script>
		<script src="../../assets/js/select2.js"></script>

		<!-- C3.JS CHART PLUGIN -->
		<script src="../../assets/plugins/charts-c3/d3.v5.min.js"></script>
		<script src="../../assets/plugins/charts-c3/c3-chart.js"></script>

		<!-- INPUT MASK PLUGIN-->
		<script src="../../assets/plugins/input-mask/jquery.mask.min.js"></script>

		<!-- JQUERY-COUNTDOWN JS-->
		<script src="../../assets/plugins/jquery-countdown/jquery.plugin.min.js"></script>
		<script src="../../assets/plugins/jquery-countdown/jquery.countdown.js"></script>
		<script src="../../assets/plugins/jquery-countdown/countdown.js"></script>

        <!-- CONSTRUCTION -->
		<script src="../../assets/js/construction.js"></script>

		<script src="{{ asset('../../assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('../../assets/js/sweet-alert.js') }}"></script>        

		<!-- CUSTOM JS -->
		<script src="../../assets/js/custom.js"></script>
        <script>
            $(document).ready(function(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $("#sync").click(function(){
					
					$('#progress').removeClass('d-none')
					$('#success-alert').addClass('d-none')

                    $.ajax({
                        url: '/sync',
                        type: 'POST',
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (response) { 
                            console.log(response)
                            $.ajax({
                                url: 'https://ceroka.cabi-dz.net/api/sync',
								headers: {
									'Content-Type': 'application/x-www-form-urlencoded'
								},
                                type: 'POST',
                                data: {_token: CSRF_TOKEN,database:response},
                                dataType: 'JSON',
                                success: function (data2) { 
                                    console.log(data2)
									console.log("done")
									$('#success-alert').removeClass('d-none')
									$('#progress').addClass('d-none')
									swal("Synchronistaion Terminé", "Cliquer pour fermer", "success");

                                },
                                error:function(){
                                    console.log('ALi')
                                },
								complete: function(){
								}

                            });
                        },
                        error:function(){
                            console.log('Test Al')
                        }
                    }); 
                });
            });    
        </script>

	</body>
</html>
