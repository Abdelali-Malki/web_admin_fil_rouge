@extends('layouts.app')



@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">New Color</h1>

    <div class="btn-toolbar mb-2 mb-md-0">

        <div class="btn-group me-2">

            <a href="{{ route('color') }}" class="btn btn-sm btn-secondary">List</a>

        </div>

    </div>

</div>



<div class="container">

    <form method="POST" action="{{ route('color-new') }}" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">

            <label for="name" class="form-label">Name</label>

            <input type="text" class="form-control" id="name" name="title" value="{{ old('title') }}">

            @error('title')

            <div class="error text-red">

                <strong>{{ $message }}</strong>

            </div>

            @enderror

          </div>

          <div class="mb-3">

            <label for="cover_photo" class="form-label">Photo</label>

            <input class="form-control" type="file" id="cover_photo" name="photo">

            <p>Image size should be 300px X 200px</p>

            @error('photo')

            <div class="error text-red">

                <strong>{{ $message }}</strong>

            </div>

            @enderror

          </div>

          <div class="">

              <button type="submit" class="btn btn-sm btn-success">Submit</button>

          </div>

    </form>

</div>

@endsection
