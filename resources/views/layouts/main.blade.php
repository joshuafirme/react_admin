<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Admin Lte Stylesheets -->

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.css') }}">

    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>
    
     <!-- notification-->
   <script src="https://js.pusher.com/4.2/pusher.min.js"></script>
</head>
@if(!Auth::user())
 <?php header('Location: /'); exit; ?>
@endif
    
<body class="hold-transition sidebar-mini skin-blue">

    <div class="wrapper">
        
        @include('layouts.components.navbar')
        @include('layouts.components.sidebar')

        @yield('content')

        
        @include('layouts.components.control-sidebar')
        
        @include('layouts.components.footer')

        
    </div>

</body>
    
    <!-- Scripts -->
    <script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
    <script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>
</html>
