@extends('layouts.app')

@section('title', '| Edit photo')

@section('content')
<div class="row">

    <div class="col-md-6 col-md-offset-3">

        <h1>Edit {{ucfirst($file->name)}}</h1>
        <hr>
            {{ Form::model($file, array('route' => array('update_photo', $file->id), 'method' => 'PUT','files'=>'true')) }}
            <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}<br>

            {{ Form::label('description', 'Description') }}
            {{ Form::text('description', null, array('class' => 'form-control')) }}<br>

            {{ Form::label('photo', 'Image') }}
            {{ Form::file('photo', array('class' => 'form-control')) }}

            {{-- @php
            $s = str_split($file->hash, 10);
            @endphp
            <img src="/storage/uploads/{{ $s['0'] }}/{{ $s['1'] }}/{{ $s['2'] }}/{{$file->photo}}" height="100" width="100"> --}}
            <div class="form-group">
            {{ Form::label('parent_id', 'Move to') }}<br>
            {{ Form::text('parent_id', null, array('class' => 'form-control')) }}
            </div>
            {{ Form::submit('Update post ( '.$file->name.' )', array('class' => 'btn btn-primary')) }}
            <a href="{{ route('index_page') }}" class="btn btn-primary">Back</a>
            {{ Form::close() }}
    </div>
    </div>
</div>

@endsection