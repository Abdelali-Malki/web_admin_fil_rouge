@extends('layouts.login')

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card" id="form_content">
    <div class="text-center login_form_header" style="background: #A6227F; padding:10px">
        @if (env("ADMIN_LOGO") !="" && file_exists(public_path("upload/" . env("ADMIN_LOGO"))))
            <img src="{{asset('/upload/')."/".env("ADMIN_LOGO")}}" alt="{{ config('app.name', 'Laravel') }}" class="mb-0 mt-2" alt="" width="120" />
        @else
           <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="mb-0 mt-2" alt="" width="" />
        @endif
    </div>
    <div class="card-body">
        <div class="mb-3">
            <h5 class="mb-1 fw-normal">{{ __('Please sign in') }}</h5>
        </div>

        @if (session('register'))
            <div class="alert alert-success">Successfully installed. Please login to access admin panel.</div>
        @endif

      @if(session()->has('message'))
            <div class="alert alert-danger">
                {{ session()->get('message') }}
            </div>
        @endif
      <p class="card-text">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-2">
                <input id="floatingInput" type="email" class="form-control" placeholder="name@example.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <label for="floatingInput">{{ __('E-Mail Address') }}</label>
                </div>

                @error('email')
                    <p class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror

                <div class="form-floating mb-2">
                    <input id="floatingPassword" type="password" class="form-control" name="password" placeholder="password" required>
                    <label for="floatingPassword">{{ __('Password') }}</label>
                </div>

                @error('password')
                    <p class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror

                <button class="mt-3 w-100 btn btn-primary" type="submit" style="background-color:#A6227F !important; border-color:#A6227F !important">Sign in</button>

                    <?php if(\App\Models\User::count()==0):?>
                    <p>Don't have account? <a href="{{ route('register') }}">{{ __('Register') }}</a></p>
                    <?php endif;?>

                <p class="mt-3 mb-3 text-muted">© <?= date("Y");?> By {{env('APP_NAME')}}</p>
            </form>
        </p>
    </div>
  </div>
@endsection
