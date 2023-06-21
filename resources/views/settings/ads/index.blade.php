@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ads & Notification</h1>
</div>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@php
$st = [
    "ON"=>"ON",
    "OFF"=>"OFF"
    ];
@endphp
<div class="container">

    <form method="POST" action="{{ route('ads_settings') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="hidden" name="ap" value="ads">
            <label for="title" class="form-label">Ads Status</label>
            <input type="hidden" name='settings_key[]' value="ADS_STATUS">
            <select class="form-control" name='settings_val[]' value="{{ env('ADS_STATUS') }}">
                @foreach ($st as $v)
                    <option value="{{$v}}" <?=($v == env("ADS_STATUS"))?"selected":"" ?> >{{$v}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="about_us" class="form-label">AdMob App Open Ad Unit ID</label>
            <input type="hidden" name='settings_key[]' value="MOBILE_APP_OPEN_AND_UNIT_ID">
            <input type="text" class="form-control" id="about_us" name='settings_val[]' value="{{ env('MOBILE_APP_OPEN_AND_UNIT_ID') }}" disabled="">
            <input type="hidden" class="form-control" id="about_us" name='settings_val[]' value="{{ env('MOBILE_APP_OPEN_AND_UNIT_ID') }}" >
          
            <div class="image_pop">
                
                <!-- Modal -->
              
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="share_link" class="form-label col">AdMob Banner Ad Unit ID</label>
            <div class="form-check form-switch mb-3 col">

                <input class="form-check-input status" id="status2" type="checkbox" <?=(env("ADD_BANNER_ADD_STATUS") == "on")?"checked":""; ?>  name='ADD_BANNER_ADD_STATUS'>
                <label class="form-check-label status1" for="status2"><span>Enabled</span></label>
            </div>
            <div class="col-12">
                <input type="hidden" name='settings_key[]' value="ADD_MOBILE_BANNER_UNIT_ID">
                <input type="text" class="form-control" id="share_link" name='settings_val[]' value="{{ env('ADD_MOBILE_BANNER_UNIT_ID') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="share_link" class="form-label col">AdMob Interstitial Ad Unit ID</label>
            <div class="form-check form-switch mb-3 col">

                <input class="form-check-input status1" id="status11" type="checkbox" <?=(env("ADD_MOBILE_ADD_STATUS") == "on")?"checked":""; ?>  name='ADD_MOBILE_ADD_STATUS'>
                <label class="form-check-label status1" for="status11">Enabled</label>
            </div>
            <div class="col-12">
                <input type="hidden" name='settings_key[]' value="ADD_MOBILE_INITIAL_ADD_UNIT">
                <input type="text" class="form-control" id="share_link" name='settings_val[]' value="{{ env('ADD_MOBILE_INITIAL_ADD_UNIT') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="share_link_2" class="form-label col">Interstitial Ad Interval</label>
            <div class="col-12">
                <input type="hidden" name='settings_key[]' value="ADD_INTERSTITIAL_INTERVAL">
                <input type="number" class="form-control" id="share_link_2" name='settings_val[]' value="{{ env('ADD_INTERSTITIAL_INTERVAL') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="about_us" class="form-label">Push notification authorization key</label>
            <input type="hidden" name='settings_key[]' value="NOTIFICATION_AUTHORIZATION_KEY">
            <textarea class="form-control" name="settings_val[]">{{ env('NOTIFICATION_AUTHORIZATION_KEY') }}</textarea>
        </div>

        <div class="">
            <button type="submit" class="btn btn-sm btn-success">Update Settings</button>
        </div>

    </form>
</div>

@endsection
@section('js')
<script>
$(document).ready(function () {
    $(document).on("click",".status1",function(){
        let v = $("#status1").val();
        if(v=="on"){
            $("#status1").val("off")
        }else{
            $("#status1").val("on")
        }
    });

    $(document).on("click",".status",function(){
        let v = $("#status").val();
        if(v=="on"){
            $("#status").val("off")
        }else{
            $("#status").val("on")
        }
    });

});
</script>

@endsection
