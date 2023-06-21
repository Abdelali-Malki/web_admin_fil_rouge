@extends('layouts.login')

@section('content')

@php

    $version = phpversion();
    $step = @$_GET["step"];
    $all_extension = get_loaded_extensions();
    $ex_bcmatch= array_search("bcmath",$all_extension);
    $ex_ctype= array_search("ctype",$all_extension);
    $ex_fileinfo= array_search("fileinfo",$all_extension);
    $ex_json= array_search("json",$all_extension);
    $ex_openssl= array_search("openssl",$all_extension);
    $ex_pdo= array_search("PDO",$all_extension);
    $ex_tokenizer= array_search("tokenizer",$all_extension);
    $ex_xml= array_search("xml",$all_extension);
    $ex_gd= array_search("gd",$all_extension);


@endphp

@if (@$_GET["step"] != 2)

    <div class="card" id="requirment_div" style="width: 28rem;">
        <div class="text-center" style="background: #A6227F; padding:10px 0px 15px;">
            <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" class="mb-0 mt-2" alt="" width="120" />
        </div>

        <div class="card-body">
            <div class="alert alert-success step_classes" role="alert">Step 1/3</div>
            <h5 class="card-title">{{ __('App Installation Requirements') }}</h5>

            <p class="card-text">
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">PHP >= 7.3</div>
                        <span class="badge <?= ($version >= 7.3)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($version >= 7.3)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">BCMath PHP Extension</div>
                        <span class="badge <?= ($ex_bcmatch)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center "><?= ($ex_bcmatch)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">Ctype PHP Extension</div>
                        <span class="badge <?= ($ex_ctype)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_ctype)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">Fileinfo PHP Extension</div>
                        <span class="badge <?= ($ex_fileinfo)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_fileinfo)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">JSON PHP Extension</div>
                        <span class="badge <?= ($ex_json)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_json)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">OpenSSL PHP Extension</div>
                        <span class="badge <?= ($ex_openssl)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_openssl)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">PDO PHP Extension</div>
                        <span class="badge <?= ($ex_pdo)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_pdo)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">Tokenizer PHP Extension</div>
                        <span class="badge <?= ($ex_tokenizer)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_tokenizer)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">XML PHP Extension</div>
                        <span class="badge <?= ($ex_xml)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_xml)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">GD Library PHP Extension</div>
                        <span class="badge <?= ($ex_gd)?"bg-success":"bg-danger";?> rounded-pill d-flex justify-content-center"><?= ($ex_gd)?'<i class="fa fa-check-circle fa-2x h_w"></i>':'<i class="fa fa-times-circle fa-2x h_w"></i>' ;?></span>
                    </li>
                </ol>
            </p>
            @if ($version >= 7.3 && $ex_bcmatch && $ex_ctype && $ex_fileinfo && $ex_json  && $ex_openssl  && $ex_pdo  && $ex_tokenizer && $ex_xml )
                <button class="btn btn-primary text-center w-100" id="next-btn">Next</button>
            @endif
        </div>
    </div>

@endif

@if ($version >= 7.3)
<div class="card" id="form_content" style="width: 28rem;">
    <div class="text-center" style="background: #A6227F; padding:10px 0px 15px;">
        <img src="{{ asset('images/common/logo/Wallpaper71LogoColor.png') }}" class="mb-0 mt-2" alt="" width="120" />
    </div>
    <div class="card-body">
        <div class="alert alert-success step_classes" role="alert">Step 2/3</div>
        <div class="mb-3">
            <h5 class="mb-1 fw-normal">{{ __('Database Information') }}</h5>
        </div>
      @if(session()->has('message'))
            <div class="alert alert-danger">
                {{ session()->get('message') }}
            </div>
        @endif
      <p class="card-text">
        <form method="POST" action="{{ route('install') }}" >
            @csrf
            <div class="form-floating mb-2">
              <input id="host" type="text" class="form-control" placeholder="example_host.com" name="host_name" value="{{ @$_GET["host"]}}" required autocomplete="host" autofocus>
              <label for="host">{{ __('Host Name') }}</label>

              @error('host_name')
                <p class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </p>
             @enderror
            </div>

            <div class="form-floating mb-2">
              <input id="database_name" type="text" class="form-control" name="database" value="{{ @$_GET["database"]}}" placeholder="Database Name" required>
              <label for="database_name">{{ __('Database Name') }}</label>
                @error('database')
                    <p class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div>

            <div class="form-floating mb-2">
                <input id="database_user" type="text" class="form-control" name="user_name" placeholder=" User Name"  value="{{ @$_GET["username"]}}" required>
                <label for="database_user">{{ __('Database User Name') }}</label>

                @error('user_name')
                  <p class="alert alert-danger" role="alert">
                      <strong>{{ $message }}</strong>
                  </p>
               @enderror
            </div>

            <div class="form-floating mb-2">
                <input id="database_password" type="password" class="form-control" value="{{ @$_GET["password"]}}" name="password" placeholder="Database password" >
                <label for="database_password">{{ __('Database Password') }}</label>

                @error('password')
                    <p class="alert alert-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </p>
                @enderror
            </div>

            <div class="checkbox mb-3 mt-3">
            <button class="w-100 btn btn-primary" type="submit">{{__("Install")}}</button>

        </form>
      </p>
    </div>
  </div>
@endif

@endsection
@section('js')

<script>
$(document).ready(function () {
    const step = "<?= @$step ?>";
    if(step == 2){
        $("#form_content").show();
    }else{
        $("#form_content").hide();
    }

    $(document).on("click","#next-btn",function(){
        $("#requirment_div").hide();
        $("#form_content").show();
    })
})

</script>
@endsection
