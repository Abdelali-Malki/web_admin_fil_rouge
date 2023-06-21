@extends('layouts.login')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="width: 28rem;">
                <div class="text-center" style="background: #A6227F; padding:10px">
                    <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" alt="" width="120">
                </div>

                <div class="card-body">
                    @if (@$_GET['register'] == true)
                        <div class="alert alert-success step_classes" role="alert">Step 3/3</div>
                    @endif
                    <h5 class="mb-3">{{ __('App Information') }}</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register',["register"=>@$_GET['register']]) }}">
                        @csrf

                        @if (@$_GET['register'] == true)
                        <div class="form-floating  mb-2">
                            <input id="app_name" type="text" class="form-control" placeholder="Your app name" name="app_name" value="{{ old('app_name') }}"  autocomplete="app_name" autofocus>
                            <label for="app_name">{{ __('App Name') }}</label>
                          </div>
                        @endif

                        <div class="form-floating mb-2">
                            <input id="name" type="text" class="form-control" placeholder="Your name" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                            <label for="name">{{ __('Full Name') }}</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input id="email" type="email" class="form-control" placeholder="email@example.com" name="email" value="{{ old('email') }}"  autocomplete="email">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                        </div>

                        <div class="form-floating mb-2">
                        <input id="password" type="password" class="form-control spassword" placeholder="Your password" name="password" value="{{ old('password') }}"  autocomplete="password" >
                        <label for="password" id="l_pass">{{ __('Password') }}</label>
                        </div>

                        <div class="form-floating mb-2">
                        <input id="password-confirm" type="password" class="form-control spassword" placeholder="Confirm Password" name="password_confirmation" value="{{ old('password_confirmation') }}"  autocomplete="password_confirmation">
                        <label for="password-confirm" id="c_pass">{{ __('Confirm Password') }}</label>
                        </div>

                        <div class="form-floating mb-2">
                            <input id="purchase-code" type="text" class="form-control" placeholder="Envato Purchase Code" name="purchase_code" value="{{ old('purchase_code') }}">
                            <label for="purchase-code" id="c_pass">{{ __('Envato Purchase Code') }}</label>
                        </div>

                        <div class="form-group row mt-3" id="register_div">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="w-100 btn btn-primary" style="background-color:#A6227F !important; border-color:#A6227F !important">
                                    {{ __('Install Now') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <link rel="stylesheet" href="{{asset('passstrength/passtrength.css')}}" media="screen" title="no title">
<style>
    .form-signin {
        max-width: 450px !important;
    }
</style>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('passstrength/jquery.passtrength.js')}}"></script>
<script>
    $(document).ready(function () {
        $(document).on("keyup","#password",function(){
            $("#l_pass").hide();

            $('#password').passtrength({
                minChars: 6,
                passwordToggle: true,
                tooltip: true
            });

            if($(".tooltip").html() == "Min 6 chars" || $(".tooltip").html() == "Weak"){
                $("#register_div").hide();
            }else{
                $("#register_div").show();
            }
            $('#password').focus();
        })

        $(document).on("keyup","#password-confirm",function(){
            $("#c_pass").hide();
            $('#password-confirm').passtrength({
                minChars: 6,
                passwordToggle: true,
                tooltip: true
            });

            if($(".tooltip").html() == "Min 6 chars" || $(".tooltip").html() == "Weak"){
                $("#register_div").hide();
            }else{
                $("#register_div").show();
            }
            $('#password-confirm').focus();
        })
    });
</script>

@endpush
