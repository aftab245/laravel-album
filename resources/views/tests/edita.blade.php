@extends('layouts.app')

@section('title', '| Edit User')

@section('content')

<div class='col-lg-4 col-lg-offset-4'>
    <h1> Edit </h1>
    <hr>

    {{ Form::model($directory, array('route' => array('update_album', $directory->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', null, array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('meta', 'Information') }}<br>
        {{ Form::text('meta', null, array('class' => 'form-control')) }}

    </div>

    <div class="form-group">
        {{ Form::label('parent_id', 'Move to') }}<br>
        {{ Form::text('parent_id', null, array('class' => 'form-control')) }}

    </div>

    {{ Form::submit('Update ( '.$directory->name.' )', array('class' => 'btn btn-success')) }}
    <a class="btn btn-primary" href="{{ route('index_page') }}"> Back</a>
    {{ Form::close() }}

</div>

@endsection