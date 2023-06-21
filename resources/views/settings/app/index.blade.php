@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">App Settings</h1>
</div>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container">

    <form method="POST" action="{{ route('app_settings') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">App Title</label>
            <input type="hidden" name='settings_key[]' value="APP_NAME">
            <input type="text" class="form-control" id="title" name='settings_val[]' value="{{ env('APP_NAME') }}">
        </div>

        <div class="mb-3">
            <label for="share_link" class="form-label">Play Store URL For App Share</label>
            <input type="hidden" name='settings_key[]' value="SHARE_LINK">
            <input type="text" class="form-control" id="share_link" name='settings_val[]' value="{{ env('SHARE_LINK') }}">
        </div>

        

        <div class="form-group mb-3 row">
            <label class="form-check-label col-12" for="">Admin Logo</label>
            
            <div class="col-11">
                <input type="file" class="form-control" value="{{asset('upload/').env("ADMIN_LOGO")}}" name="admin_logo">
                <p>Image size should be 200px X 200px</p>
                @error('admin_logo')
                <div class="error text-red">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="col-1" style="text-align: right;">
                @if (env("ADMIN_LOGO") !="" && file_exists(public_path("upload/" . env("ADMIN_LOGO"))))
                    <img src="{{asset('/upload/')."/".env("ADMIN_LOGO")}}" alt="{{ env('APP_NAME') }}" class="img-fluid" style="background: #fafafa;border: 1px solid #eee; max-height: 30px;"/>
                @else
                <img src="{{ asset('images/common/logo/Wallpaper71LogoColor2.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid" style="background: #fafafa;border: 1px solid #eee;"/>
                @endif
            </div>
            
        </div>


        <div class="form-group mb-3 row">
            <label class="form-check-label col-12" for="">Favicon</label>
            <div class="col-11">
                <input type="file" class="form-control" value="{{asset('upload/').env("FAV_ICON")}}" name="fav_icon">
                <p>Image size should be 72px X 72px</p>
                @error('fav_icon')
                <div class="error text-red">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            <div class="col-1" style="text-align: right;">
                @if (env("FAV_ICON") !="" && file_exists(public_path("upload/" . env("FAV_ICON"))))
                    <img src="{{asset('/upload/')."/".env("FAV_ICON")}}" alt="{{ env('APP_NAME') }}" class="img-fluid" style="background: #fafafa;border: 1px solid #eee; max-height: 30px;"/>
                @else
                    <img src="{{ asset('images/common/logo/Wallpaper71LogoColor2.png') }}" alt="{{ env('APP_NAME') }}" class="img-fluid" style="background: #fafafa;border: 1px solid #eee; max-height: 30px;"/>
                @endif
            </div>
        </div>

        <div class="form-group mb-3 row">
            <label class="form-check-label col-12" for="">Most Popular Item Background Image</label>
            <div class="col-lg-11">
                <input type="file" class="form-control" value="{{asset('upload/').env("MOST_POPULAR")}}" name="most_popular">
                <p>Image size should be 860px X 357px</p>
                @error('most_popular')
                <div class="error text-red">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            @if (env("MOST_POPULAR") !="")
            <div class="col-1" style="text-align: right;">
                <img class="img-fluid" width="50" src="{{asset('/upload/')."/".env("MOST_POPULAR")}}" alt="Fav Icon">
            </div>
            @endif
        </div>

        

        <div class="form-group mb-3 row">
            <label class="form-check-label col-12" for="">Recent Photo Item Background Image</label>
            <div class="col-11">
                <input type="file" class="form-control" value="{{asset('upload/').env("RECENT")}}" name="recent">
                <p>Image size should be 860px X 357px</p>
                @error('recent')
                <div class="error text-red">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>
            @if (env("RECENT") !="")
            <div class="col-1" style="text-align: right;">
                <img class="img-fluid" width="50" src="{{asset('/upload/')."/".env("RECENT")}}" alt="Fav Icon">
            </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="fssdt" class="form-label">Full Screen Slider Delay Time (Second)</label>
            <input type="hidden" name='settings_key[]' value="FULL_SCREEN_SLIDER_DELAY">
            <input type="number" class="form-control" id="fssdt" name='settings_val[]' value="{{ env('FULL_SCREEN_SLIDER_DELAY') }}" min="1">
        </div>

        <div class="mb-3">
            <label for="about_us" class="form-label">About Us</label>
            <input type="hidden" name='settings_key[]' value="ABOUT_US_LINK">
            <textarea class="form-control" id="about_us" name='settings_val[]' rows="4"><?=urldecode(env('ABOUT_US_LINK'))?></textarea>
        </div>

        <div class="mb-3">
            <label for="privacy_policy" class="form-label">Privacy Policy</label>
            <input type="hidden" name='settings_key[]' value="PRIVACY_POLICY_DATA">
            <textarea class="form-control" id="privacy_policy" name='settings_val[]' rows="4"><?=urldecode(env('PRIVACY_POLICY_DATA'))?></textarea>
        </div>

        <div class="">
            <button type="submit" class="btn btn-sm btn-success">Update Settings</button>
        </div>
    </form>
</div>

@endsection
