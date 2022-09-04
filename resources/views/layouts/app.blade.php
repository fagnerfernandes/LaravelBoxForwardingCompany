<!doctype html>
<html lang="pt-br" class="color-sidebar sidebarcolor4 color-header headercolor2">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="/favicon.png" type="image/png" />
	<!--plugins-->
	@yield("style")
	<link href="/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="/assets/css/pace.min.css" rel="stylesheet" />
	<script src="/assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet" />
	<link href="/assets/css/app.css" rel="stylesheet" />
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet' />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" />
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" />


    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="/assets/css/header-colors.css" />

    <link href="/assets/css/personalized.css" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('css')
	@stack('top-css')

    <title>Company - {{ $title ?? '' }}</title>

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            opacity: 1;
        }
    </style>

	@livewireStyles
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
        <!--navigation-->
        @include("layouts.nav")
        <!--end navigation-->

		<!--start header -->
		@include("layouts.header")
		<!--end header -->

        <div class="page-wrapper">
            <div class="page-content">

                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item">
                                    <a href="{{ url('/dashboard') }}">
                                        <i class="bx bx-home-alt"></i> Dashboard
                                    </a>
								</li>
                                @yield('breadcrumbs')
								{{-- <li class="breadcrumb-item active" aria-current="page">Google Maps</li> --}}
							</ol>
						</nav>
					</div>
				</div>

                <!--start page wrapper -->
                @include('flash::message')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield("wrapper")
                <!--end page wrapper -->
            </div>
        </div>
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->

    <!-- Bootstrap JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="/js/jquery.priceformat.min.js"></script>
    <script src="/js/jquery.mask.min.js"></script>
    <script src="/js/masks.js"></script>
	<!--app JS-->
	<script src="/assets/js/app.js"></script>

    <script src="/js/dollar.js?v2"></script>
	@yield("scripts")
    @include("layouts.theme-control")
	@livewireScripts
	@stack('bottom-scripts')
</body>

</html>
