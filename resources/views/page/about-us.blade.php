@extends('layouts.share')

@section('title', 'About Us')

@section('content')

@section('imagelink', asset('images/common/logo/Wall71ColorIcon.png'))

<p><img src="{{ asset('images/common/logo/Wall71ColorIcon.png') }}" class="img-fluid" style="border-radius: 8px; max-width: 100px"/></p>

<div class="row">


    <div class="col-md-12 d-flex align-items-center justify-content-center">
        <div>
            <h1>About Us</h1>

            <p>Coder71 Ltd. is an established web development company delivering web development services of any complexity to clients worldwide. Being in IT business for over some years now we have a strong team of skilled experienced IT experts. Our customers are companies of all sizes ranging from startups to large enterprises who realize that they need a professional internet solution to generate revenue streams, establish communication channels or streamline business operations.</p>
        </div>
    </div>
</div>





@endsection