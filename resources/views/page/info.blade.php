@extends('layouts.share')

<?php if($slug=='privacy-policy'){
    $title = 'Privacy Policy';
}else{
    $title = 'About Us';
}?>

@section('title', $title)

@section('content')



<p>
    @if (env("ADMIN_LOGO") !="" && file_exists(public_path("upload/" . env("ADMIN_LOGO"))))
        @section('imagelink', asset('/upload/')."/".env("ADMIN_LOGO"))
        <img src="{{asset('/upload/')."/".env("ADMIN_LOGO")}}" alt="{{ env('APP_NAME') }}" class="img-fluid" style="border-radius: 8px; max-width: 100px"/>
    @else
        @section('imagelink', asset('images/common/logo/Wallpaper71LogoColor.png'))
        <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="border-radius: 8px; max-width: 100px"/>
    @endif
</p>

<div class="row">
    <div class="col-md-12 d-flex align-items-center justify-content-center">
        <div class="col-12">
            <h1>{{ $title }}</h1>

                <?php if($slug=='privacy-policy'){
                    echo \urldecode(env('PRIVACY_POLICY_DATA'));
                }else{
                    echo nl2br(\urldecode(env('ABOUT_US_LINK')));
                }?>
            
        </div>
    </div>
</div>





@endsection