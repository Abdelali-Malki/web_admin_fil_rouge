@extends('layouts.share')

@section('title', 'Privacy Policy')

@section('content')

@section('imagelink', asset('images/common/logo/Wall71ColorIcon.png'))

<p><img src="{{ asset('images/common/logo/Wall71ColorIcon.png') }}" class="img-fluid" style="border-radius: 8px; max-width: 100px"/></p>

<div class="row">


    <div class="col-md-12 d-flex align-items-center justify-content-center">
        <div>
            <h1>Privacy Policy</h1>

            <p>We don't collect any user information, when accessing or using our app and this service.</p>

            <p>We only ask media permission when user try to download the images.</p>

            <p><strong>From where collect these images:</strong></p>

            <ul>
                <li>We collect from some free site like <a href="https://www.pexels.com" target="_blank">https://www.pexels.com</a> and <a href="https://pixabay.com" target="_blank">https://pixabay.com</a> right now</li>
                <li>Also we have our own photographer, who will take photos and upload here also.</li>
            </ul>

            <p><strong>User device information:</strong></p>

            <p>This App have no login/registration section. For this reason when you are get into in premium user or remove Ads Then for your identity we store some your device info. like your device id for your better service</p>

            <p><strong>Design Credits:</strong></p>

            <p>We also take some design from this site also https://lottiefiles.com/64327-rainbow-loader-animation</p>
        </div>
    </div>
</div>





@endsection