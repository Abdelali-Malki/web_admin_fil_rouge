@extends('layouts.share')

@section('title', $model->name)

@section('content')

@section('imagelink', asset('images/products/'.$model->photo))

<p>
    @if (env("ADMIN_LOGO") !="" && file_exists(public_path("upload/" . env("ADMIN_LOGO"))))
        <img src="{{asset('/upload/')."/".env("ADMIN_LOGO")}}" alt="{{ env('APP_NAME') }}" class="img-fluid" style="border-radius: 8px;/>
    @else
        <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="border-radius: 8px;"/>
    @endif
</p>



<div class="row">

    <div class="col-md-12">
        <p><img src="{{ asset('images/products/'.$model->photo) }}" alt="{{ $model->name }}" class="img-fluid" style="max-height: 300px; border:solid 2px #fff; border-radius:10px;"/></p>
    </div>

    <div class="col-md-12 d-flex align-items-center justify-content-center">
        <div>
            <h1>{{ $model->name }}</h1>

            @if($model->description)

                <p class="lead">{{ $model->description }}</p>

                @section('description', $model->description)

            @endif

            @if($model->tags)

            @section('keywords', $model->tags)

            @endif

        </div>

    </div>

</div>

@endsection
