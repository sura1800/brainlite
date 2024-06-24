<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brainlite | Log in</title>
    <!-- <link rel="icon" type="image/x-icon" href="/favicon.png"> -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset(asset_path('assets/admin/plugins/fontawesome-free/css/all.min.css'))}}">

    <link rel="stylesheet" href="{{asset(asset_path('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'))}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset(asset_path('assets/admin/css/adminlte.min.css'))}}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="" class="h1">User Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="false">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block w-100">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                     @endif
                </div>
                <div class="flex items-center justify-end mt-1">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                        {{ __('Not registered? Sign Up Now') }}
                    </a>
                </div>
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset(asset_path('assets/admin/plugins/jquery/jquery.min.js'))}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset(asset_path('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'))}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset(asset_path('assets/admin/js/adminlte.min.js'))}}"></script>
</body>

</html>