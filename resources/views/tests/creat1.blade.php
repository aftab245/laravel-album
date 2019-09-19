@extends('layouts.app')

@section('title', '| Create New Post')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 well">

        <h1> Upload photo </h1>
        <hr>

    {{-- Using the Laravel HTML Form Collective to create our form --}}
        {{ Form::open(array('route' => 'store_photo','method'=>'POST','files'=>'true')) }}

        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
            <br>
            
            {{ Form::label('description', 'Description') }}
            {{ Form::textarea('description', null, array('class' => 'form-control','rows'=>'2')) }}
            <br>

            {{ Form::label('photo', 'Image') }}
            {{ Form::file('photo', array('class' => 'form-control')) }}
            <br>

            {{ Form::submit('Upload', array('class' => 'btn btn-success btn-block')) }}
            {{ Form::close() }}
        </div>
        </div>
    </div>
    </div>

@endsection