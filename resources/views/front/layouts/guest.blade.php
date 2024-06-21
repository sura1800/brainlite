<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset(asset_path('assets/front/images/favicon/favicon-32x32.png'))}}" sizes="32x32" />
    <link rel="icon" href="{{asset(asset_path('assets/front/images/favicon/favicon-192x192.png'))}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset(asset_path('assets/front/images/favicon/favicon.png'))}}" />
    <meta name="msapplication-TileImage" content="{{asset(asset_path('assets/front/images/favicon/favicon.png'))}}" />

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/toastr/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{asset(asset_path('assets/admin/plugins/fontawesome-free/css/all.min.css'))}}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Scripts -->


    <style>
        input {
            border: 1px solid #00cb35c4 !important;
            background-color: #f0ffef !important;
            height: 35px !important;
            border-radius: 18px !important;
            padding: 0px 15px !important;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.11.1/cdn.js"></script>
    <script src="{{asset(asset_path('assets/front/js/vendor/jquery-3.6.0.min.js'))}}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/toastr/toastr.min.js')) }}"></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div style="text-align:center;">
            <a href="/">
                <img style="width:5%; margin:0 auto;" src="{{asset(asset_path('upload/front/logo/jb-logo.png'))}}" alt="logo">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    @stack('scripts')
</body>

</html>