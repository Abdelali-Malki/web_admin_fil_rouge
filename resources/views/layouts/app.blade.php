<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $fav = env("FAV_ICON");
    @endphp

    @if (env("FAV_ICON")!="" )
    <link rel="icon" type="image/png" sizes="512x512" href="{{asset('/upload')."/".env("FAV_ICON")}}">
    @else
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Data Tables -->
    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Cropper JS -->
    <link href="{{ asset('css/cropper.css') }}" rel="stylesheet">

    <!-- Select 2 Css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Tagify -->
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

      <script src="https://kit.fontawesome.com/d9d60fe2a7.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>


    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 text-center" href="{{ url('/') }}">
        @if (env("ADMIN_LOGO") !="" && file_exists(public_path("upload/" . env("ADMIN_LOGO"))))
            <img src="{{asset('/upload/')."/".env("ADMIN_LOGO")}}" alt="{{ env('APP_NAME') }}" class="img-fluid" style="border-radius: 8px; max-width: 30px"/>
        @else
           <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="border-radius: 8px; max-width: 30px"/>
        @endif
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">

            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

          </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
              <ul class="nav flex-column">

                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" data-route="home" href="{{ route('home') }}">
                    <span data-feather="home"></span>
                    Dashboard
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-route="products" href="{{ route('products') }}">
                    <span data-feather="layers"></span>
                    Wallpapers
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-route="collections" href="{{ route('collections') }}">
                    <span data-feather="layers"></span>
                    Categories
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-route="color" href="{{ route('color') }}">
                    <span data-feather="circle"></span>
                    Colors
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-route="app_settings" href="{{ route('app_settings') }}">
                    <span data-feather="settings"></span>
                    App Settings
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-route="ads_settings" href="{{ route('ads_settings') }}">
                    <span data-feather="tool"></span>
                    Ads & Notification
                  </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" type="button" data-route="update-profile" href="{{ route('update-profile') }}">
                      <span data-feather="user"></span>
                      Update Profile
                    </a>
                </li>

                <li class="nav-item">
                     <a class="nav-link" type="button" data-route="notification-history" href="{{route('notification-history')}}" >
                      <span data-feather="bell"></span>
                      Send Push Notification
                    </a>
                </li>

              </ul>

            </div>
          </nav>

          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('content')
            <div class="site_footer">
              <p class="mt-3 mb-3 text-muted">© <?= date("Y");?> By {{env('APP_NAME')}}</p>
            </div>
          </main>
        </div>
      </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
      var BASE_URL = "{{ route('home') }}";
      var CURRENT_ROUTE_NAME = "{{ Route::current()->getName() }}";
    </script>

    <script src="{{ asset('js/cropper.js') }}"></script>
    <script src="{{ asset('js/jquery-cropper.js') }}"></script>
    <!-- Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/jQuery.tagify.min.js') }}"></script>

    <script src="{{ asset('js/dashboard.js') }}"></script>

    @stack('scripts')


</body>
</html>
