<!DOCTYPE html>

<html lang="en" class="default-style">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Barlow:wght@300;400&family=Material+Icons&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        window.Laravel = {!! json_encode([
            'user' => [
                'authenticated' => auth()->check(),
                'is_admin'=>auth()->check() ? auth()->user()->is_admin : null,
                'id' => auth()->check() ? auth()->user()->id : null,
                'firstname' => auth()->check() ? auth()->user()->firstname : null,
                'lastname' => auth()->check() ? auth()->user()->lastname : null,
                'email' => auth()->check() ? auth()->user()->email : null
            ]
        ]) !!}
    </script>
    <script>
        function S4() {
            return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
        }

        function guid() {
            return (S4()+S4()+""+S4()+""+S4()+""+S4()+""+S4()+S4()+S4());
        }

    </script>


    @yield('head')
</head>
<body class="{{$body_class}}">

<div id="app">
    <alerts :is_mobile="isMobile" :alerts="alerts" @dismissalert="dismissAlert"></alerts>
    @yield('content')
</div>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('/js/app.js') }}"></script>



@yield('scripts')
</body>
</html>
