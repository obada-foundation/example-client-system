<!DOCTYPE html>

<html lang="en" class="default-style">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('/css/base.css') }}">

    <style>
        :root {
            --gas-fee-text: '* {{ config('view.gas_fee_text') }} per transaction';
        }
    </style>

    <script>
        window.gas_fee_text = '{{ config('view.gas_fee_text') }}';
        window.Laravel = {!! json_encode([
            'user' => [
                'authenticated' => auth()->check(),
                'is_admin'      =>auth()->check() ? auth()->user()->is_admin : null,
                'id'            => auth()->check() ? auth()->user()->id : null,
                'firstname'     => auth()->check() ? auth()->user()->firstname : null,
                'lastname'      => auth()->check() ? auth()->user()->lastname : null,
                'email'         => auth()->check() ? auth()->user()->email : null
            ]
        ]) !!}
    </script>
    <script>
        function S4() {
            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        }

        function guid() {
            return (S4() + S4() + "" + S4() + "" + S4() + "" + S4() + "" + S4() + S4() + S4());
        }
    </script>


    @yield('head')
</head>

<body>

    <div id="app">
        <div id="alerts_container" class="alerts-container"></div>

        @yield('content')
    </div>

    @yield('page_bottom')

    @yield('scripts')

</body>
</html>
