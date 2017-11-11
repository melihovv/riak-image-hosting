@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>

          @if (session('image_url'))
            <p>Link to uploaded image: <a href="{{ session('image_url') }}">{{ session('image_url') }}</a></p>
          @endif
        @endif

        @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="panel panel-default">
          <div class="panel-heading">Upload image</div>

          <div class="panel-body">
            {!! Form::open([
              'route' => 'images.store',
              'method' => 'POST',
              'files' => true,
            ]) !!}
            <div class="form-group">
              {!! Form::file('image') !!}
            </div>

            {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
