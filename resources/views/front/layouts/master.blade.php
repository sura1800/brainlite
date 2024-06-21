<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Brainlite</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="JB Legal 2023">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="canonical" href="#" />

    <!-- Open Graph (OG) meta tags are snippets of code that control how URLs are displayed when shared on social media  -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="JB Legal 2023" />
    <meta property="og:url" content="{{url('/')}}" />
    <meta property="og:site_name" content="JB Legal 2023" />
    <!-- For the og:image content, replace the # with a link of an image -->
    <meta property="og:image" content="{{url('/')}}" />
    <meta property="og:description" content="JB Legal 2023" />
    <!-- Add site Favicon -->
    <link rel="icon" href="{{asset(asset_path('assets/front/images/favicon/favicon-32x32.png'))}}" sizes="32x32" />
    <link rel="icon" href="{{asset(asset_path('assets/front/images/favicon/favicon-192x192.png'))}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset(asset_path('assets/front/images/favicon/favicon.png'))}}" />
    <meta name="msapplication-TileImage" content="{{asset(asset_path('assets/front/images/favicon/favicon.png'))}}" />

    <!-- All CSS is here
	============================================ -->
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/vendor/bootstrap.min.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/vendor/pe-icon-7-stroke.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/vendor/themify-icons.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/vendor/font-awesome.min.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/plugins/animate.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/plugins/aos.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/plugins/swiper.min.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/plugins/jquery-ui.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/plugins/easyzoom.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/plugins/slinky.css'))}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.css"> -->
    <link rel="stylesheet" href="{{asset(asset_path('assets/front/css/style.css'))}}" />

</head>




<body>
    <div class="main-wrapper main-wrapper-2">
        @include('front.layouts.header')

        @yield('content')

        @include('front.layouts.footer')

        <!-- Mobile Menu start -->
        {{-- @include('front.layouts.mobile_menu') --}}
    </div>
    <!-- All JS is here -->
    <script src="{{asset(asset_path('assets/front/js/vendor/modernizr-3.11.2.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/vendor/jquery-3.6.0.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/vendor/jquery-migrate-3.3.2.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/vendor/popper.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/vendor/bootstrap.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/wow.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/scrollup.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/aos.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/swiper.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/imagesloaded.pkgd.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/jquery-ui.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/jquery-ui-touch-punch.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/slinky.min.js'))}}"></script>
    <script src="{{asset(asset_path('assets/front/js/plugins/easyzoom.js'))}}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script> -->

    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.js"></script> -->
    <!-- Main JS -->
    <script src="{{asset(asset_path('assets/front/js/main.js'))}}"></script>

</body>

</html>