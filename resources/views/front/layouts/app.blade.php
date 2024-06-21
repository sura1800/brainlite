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
    <link rel="stylesheet" href="{{asset(asset_path('assets/admin/plugins/fontawesome-free/css/all.min.css'))}}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    <style>
        .iOSBackWrapper a {
            position: fixed;
            bottom: 6px;
            left: 12px;
            font-size: 36px;
            aspect-ratio: 1;
            width: 35px;
            height: 35px;
            text-align: center;
            line-height: 35px;
            color: #646464;
            border-radius: 50%;
            box-shadow: 1px 1px 5px #333;
            background-color: #fff;
        }

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
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('front.layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- @if($detectDevice == 'iphone')
    <div class="iOSBackWrapper">
        <a href="{{ url()->previous() }}"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></a>
    </div>
    @endif --}}
</body>

</html>