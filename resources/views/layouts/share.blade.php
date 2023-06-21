<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#7952b3">

    <!-- Favicon -->
    @if (env("FAV_ICON")!="" )
    <link rel="icon" type="image/png" sizes="512x512" href="{{asset('/upload')."/".env("FAV_ICON")}}">
    @else
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Wallpaper in your hand') - {{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="@yield('description', 'Largest free wallpaper apps for your mobile')"/>
    <meta name="keywords" content="@yield('keywords', 'Free Mobile Wallpaper, 4K Wallpaper')">
    <link rel="canonical" href="@yield('canonical', url('/'))"/>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@coder71">
    <meta name="twitter:creator" content="@coder71">
    <meta name="twitter:title" content="@yield('title', 'Wallpaper in your hand') - {{ config('app.name', 'Laravel') }}">
    <meta name="twitter:description" content="@yield('description', 'Largest free wallpaper apps for your mobile')">
    <meta name="twitter:image" content="@yield('imagelink', asset('image/logo.png'))">

    <!-- Facebook -->
    <meta property="og:url" content="@yield('canonical', url('/'))">
    <meta property="og:title" content="@yield('title', 'Wallpaper in your hand') - {{ config('app.name', 'Laravel') }}">
    <meta property="og:description" content="@yield('description', 'Largest free wallpaper apps for your mobile')">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('imagelink', asset('image/logo.png'))">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="864">
    <meta property="og:image:height" content="1920">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        }

        @media (min-width: 768px) {
          .bd-placeholder-img-lg {
            font-size: 3.5rem;
          }
        }
      </style>

    <!-- Styles -->
    <link href="{{ asset('css/cover.css') }}" rel="stylesheet">
</head>
<body class="d-flex h-100 text-center text-white bg-dark">

    <div class="cover-container-ex d-flex w-100 h-100 p-3 mx-auto flex-column">
        <main class="px-3">
          @yield('content')
        </main>

        <footer class="mt-auto text-white-50">
          <p>A Product of <a href="https://coder71.com/" class="text-white">Coder71 Ltd.</a></p>
        </footer>
    </div>

</body>
</html>
