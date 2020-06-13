<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>One App</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet" />
    <link href="//fonts.googleapis.com/css?family=Roboto:400,700,300" rel="stylesheet" type="text/css" />

</head>
<body>
{{--<div class="flex-center position-ref full-height">--}}
{{--    @if (Route::has('login'))--}}
{{--        <div class="top-right links">--}}
{{--            @auth--}}
{{--                <a href="{{ url('/home') }}">Home</a>--}}
{{--            @else--}}
{{--                <a href="{{ route('login') }}">Login</a>--}}

{{--                @if (Route::has('register'))--}}
{{--                    <a href="{{ route('register') }}">Register</a>--}}
{{--                @endif--}}
{{--            @endauth--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}

<div id="app"></div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
