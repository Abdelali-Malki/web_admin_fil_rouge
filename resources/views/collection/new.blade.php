@extends('layouts.app')



@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">New Category</h1>

    <div class="btn-toolbar mb-2 mb-md-0">

        <div class="btn-group me-2">

            <a href="{{ route('collections') }}" class="btn btn-sm btn-secondary">List</a>

        </div>

    </div>

</div>



<div class="container">



    <form method="POST" action="{{ route('collections-new') }}" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">

            <label for="name" class="form-label">Name</label>

            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">

            @error('name')

            <div class="error text-red">

                <strong>{{ $message }}</strong>

            </div>

            @enderror

          </div>

          <div class="mb-3">

            <label for="description" class="form-label">Description</label>

            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>

          </div>

          <div class="mb-3">

            <label for="cover_photo" class="form-label">Cover Photo</label>

            <input class="form-control" type="file" id="cover_photo" name="cover_photo">

            <p>Image size should be 720px X 320px</p>

            @error('cover_photo')

            <div class="error text-red">

                <strong>{{ $message }}</strong>

            </div>

            @enderror

          </div>

          <div class="form-check form-switch mb-3">

            <input class="form-check-input" type="checkbox" id="status" name="status" checked>

            <label class="form-check-label" for="status">Enabled</label>

          </div>



          <div class="">

              <button type="submit" class="btn btn-sm btn-success">Submit</button>

          </div>

    </form>

</div>

@endsection