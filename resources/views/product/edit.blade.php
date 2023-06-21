@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Wallpaper</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('products') }}" class="btn btn-sm btn-secondary">List</a>
        </div>
    </div>
</div>

<div class="container">

  <div class="row">

    <div class="col-md-7 col-sm-12">

      <div class="col-sm-12 text-center">
        <label for="cover_photo" class="form-label change-image-picker btn btn-info btn-block" style="display: none">Change Photo</label>
      </div>

      <div class="col-md-12 col-sm-12 d-flex justify-content-center align-items-center image-container" style="max-height:500px; height: 500px; background-image:url('{{asset('images/products/webp/'.$model->photo.'.webp')}}'); background-repeat: no-repeat; background-size: contain; background-position: center;">

        <div style="display: none">
          <input class="form-control" type="file" id="cover_photo" name="cover_photo" onchange="preview_image(event)">
        </div>

        <label for="cover_photo" class="form-label image-picker">[Click here to select photo]</label>
        <img id="image" class="img-fluid image-cropper" style="display: none"/>

      </div>

    </div>

    <div class="col-md-5 col-sm-12">
      <form id="product" method="POST" action="{{ route('products-edit', ['id'=>$model->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ (old('name'))??$model->name }}">
            @error('name')
            <div class="error text-red">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

            @error('photo')
            <div class="error text-red">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

            <input type="hidden" class="form-control" id="photo" name="photo" value="{{ old('photo')??$model->photo }}">
          </div>

          <div class="mb-3">
            <label for="collection" class="form-label">Collections</label>
            <select id="collection" name="collections[]" class="form-select" multiple aria-label="multiple select example">
              @foreach ($data['collections']->toArray() as $id=>$name)
              @php
              $coll = explode(',', $model->collections);
              @endphp
              <option @if(in_array($id, $coll)) selected="selected" @endif value="{{ $id }}">{{ $name}}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="colors" class="form-label">Colors</label>
            <select id="colors" name="colors[]" class="form-select" multiple aria-label="multiple select example">
              @foreach ($data['colors']->toArray() as $id=>$name)
              @php
              $coll = explode(',', $model->colors);
              @endphp
              <option @if(in_array($id, $coll)) selected="selected" @endif value="{{ $id }}">{{ $name}}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <input class="form-control" id="tags" name="tags" rows="3" value="{{ old('tags')??$model->tags }}" type="text"/>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description')??$model->description }}</textarea>
          </div>



          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" @if($model->status) checked @endif>
            <label class="form-check-label" for="status">Enabled</label>
          </div>

          <div class="">
                <button id="submitProduct" type="submit" class="btn btn-sm btn-success">
                    Submit
                    <div class="spinner-border spinner-border-sm text-info" role="status" style="display: none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
          </div>
      </form>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  var productListUrl = "{{ route('products') }}";
  var tempImageDir = "{{ route('temp-image-upload') }}";
  var $image = $('#image');

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function preview_image(event)
  {
    var reader = new FileReader();
    reader.onload = function()
    {


      var output = document.getElementById('image');
      output.src = reader.result;

      var cropper = $image.data('cropper');

      if(typeof(cropper) !== 'undefined')
        cropper.replace(reader.result);
      else{
        $image.cropper({
          aspectRatio: 9 / 20,
          //maxWidth: 3000,
          dragMode: 'move',
          cropBoxResizable: false,
          crop: function(event) {

          }
        });
      }

      $('.image-picker').hide();
      $('.image-cropper').show();
      $('.change-image-picker').show();

    }
    reader.readAsDataURL(event.target.files[0]);
  }

  $(document).on('submit', '#product', function(e){
    e.preventDefault();
    var cropper = $image.data('cropper');

    $('#submitProduct').attr("disabled","disabled");
    $('#submitProduct').find('.spinner-border').show();

    if(typeof(cropper)!=='undefined'){

      cropper.getCroppedCanvas({
        maxWidth: 2200,
      }).toBlob((blob) => {
        const formData = new FormData();

        // Pass the image file name as the third parameter if necessary.
        formData.append('croppedImage', blob);

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        // Use `jQuery.ajax` method for example
        $.ajax(tempImageDir, {
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success(response) {
            var {status, image} = response;
            if(status=='success'){
              $('#photo').val(image);

              submitProductForm();

            }
          },
          error(response) {

            var {message, errors} = response.responseJSON;

            var msg = '';
            $.each(errors, function(k,v){
              msg += v[0]+'\n';
            });

            if(msg=='')
              msg = 'Something went wrong!';

            swal("Opps!", msg, "warning");

            $('#submitProduct').removeAttr("disabled");
            $('#submitProduct').find('.spinner-border').hide();

          },
        });

      }, "image/jpeg", 1);
    }else{
      submitProductForm();
    }


  });

  function submitProductForm()
  {
    var form = $('#product');

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: form.serialize(),
        success: function(response) {
          var {status, message, errors} = response;
          if(status=='success'){
            window.location = productListUrl;
          }

          if(errors){
            confirm.log(errors);
          }

        },
        error: function(response){
          var {message, errors} = response.responseJSON;

          var msg = '';
          $.each(errors, function(k,v){
            msg += v[0]+'\n';
          });

          if(msg=='')
            msg = 'Something went wrong!';

          swal("Opps!", msg, "warning");

          $('#submitProduct').removeAttr("disabled");
          $('#submitProduct').find('.spinner-border').hide();

        }
      });
  }
</script>
@endpush
