<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Welcome</title>
    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}"></script>

    @livewireStyles
</head>

<body>
    <div class="container">
        @livewire('qr-code-scanner')
    </div>

    @livewireScripts
</body>

</html>
