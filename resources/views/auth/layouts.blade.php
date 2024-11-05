<!doctype html>
<html lang="en-US">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--=== CSS Link ===--> 
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/remixicon.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/metisMenu.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/simplebar.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/prism.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">

		
		<!--=== Favicon ===-->
		<link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png')}}">
		<!--=== Title ===-->
		<title>QR code based attendance monitoring system for PRMSU Junior High School </title>
    </head>
<body>
  <div class="preloader">
    <div class="content">
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
    </div>
</div>
<!--=== End Preloader Section ===-->

    {{-- <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
          <a class="navbar-brand" href="{{ URL('/') }}">Custom Login Register</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('register')) ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    </li>
                @else    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            >Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li>
                        </ul>
                    </li>
                @endguest
            </ul>
          </div>
        </div>
    </nav>     --}}

            
		<!--=== Start Main Content Area ===-->
                @yield('content')
		<!--=== End Main Content Area ===-->


		<!-- Start Go Top Area -->
		<div class="go-top">
			<i class="ri-arrow-up-s-line"></i>
		</div>
		<!-- End Go Top Area -->

        <!--=== JS Link ===-->
        <script src="{{ asset('assets/js/jquery.min.js')}}"></script> 
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('assets/js/metisMenu.min.js')}}"></script>
        <script src="{{ asset('assets/js/countdown.min.js')}}"></script>
        <script src="{{ asset('assets/js/feather.min.js')}}"></script>
        <script src="{{ asset('assets/js/simplebar.min.js')}}"></script>
		<script src="{{ asset('assets/js/prism.js')}}"></script>
        <script src="{{ asset('assets/js/html5sortable.js')}}"></script>
        <script src="{{ asset('assets/js/members-list.js')}}"></script> 
        <script src="{{ asset('assets/js/jquery-ui.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.js')}}"></script>  
        <script src="{{ asset('assets/js/magnific-popup.min.js')}}"></script>  
        <script src="{{ asset('assets/js/sweetalert2.all.min.js')}}"></script>  
        <script src="{{ asset('assets/js/kanban-board.js')}}"></script> 

        <!--=== Apex Charts ===-->
        <script src="{{ asset('assets/js/apex/apexcharts.js')}}"></script>
		<!--=== Amcharts ===-->
        <script src="{{ asset('assets/js/amcharts/index.js')}}"></script>
        <script src="{{ asset('assets/js/amcharts/map.js')}}"></script>
        <script src="{{ asset('assets/js/amcharts/worldLow.js')}}"></script>
        <script src="{{ asset('assets/js/amcharts/Animated.js')}}"></script>
		<script src="{{ asset('assets/js/apex/analytics-chart.js')}}"></script>
		<script src="{{ asset('assets/js/custom.js')}}"></script>

        <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
</body>
</html>


