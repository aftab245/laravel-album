@extends('layouts.app')
@section('content')

<div class="container">

<h1 align="center">Album ({{$response->name}}) with id = {{$response->id}} , Parent_id = {{ $response->parent_id?$response->parent_id:'null' }}</h1>
      
<hr>
<a href="/folder/create/{{$response->id}}" class="btn btn-primary"> Add album </a>
<a href="/file/create/{{$response->id}}" class="btn btn-primary"> Upload photo </a>
<hr>
   <h1>Albums</h1>
        <hr>  
        <div class="row">
            @if(count($response->directories)>0)
             @foreach($response->directories as $d)
             <div class="col-md-3 well">
                 <h3>{{$d->id}}</h3>
                    <a href="/test/{{$d->id }}"><h1><i class="fas fa-folder"></i></h1>{{ $d->name}}</a>
                        <p class="card-text">{{$d->description }}</p>
              <a href="{{ route('edit_album', $d->id) }}" class="btn btn-info btn-sm pull-left" style="margin-right: 3px;">Edit</a>
              {!! Form::open(['method' => 'DELETE','route' => ['delete_album', $d->id],'style'=>'display:inline' ]) !!}
              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm','onclick' => 'return confirm("Are you sure u want to delete this item?");']) !!}
              {!! Form::close() !!}
             </div>
            @endforeach
          @else
        <h4>No album to display!!!</h4>
    @endif
        </div>
    <h1>Photos</h1>
        <hr>  
        <div class="row">
           @if(count($response->files)>0)
            @foreach($response->files as $d)
             <div class="col-md-3">
                 <h3>{{$d->id}} {{$d->name}}</h3>
                   <p>{{$d->description?$d->description:'null'}}</p>
                     @if(!empty($d->photo))
                       @php
                         $s = str_split($d->hash, 10);
                          @endphp
                           <img src="/storage/uploads/{{ $s['0'] }}/{{ $s['1'] }}/{{ $s['2'] }}/{{$d->photo}}" height="250" width="100%">
                            <br> 
                             <em> size: {{ ($d->size>1024)?round(($d->size/1024),1).' KB':$d->size }}</em>
                           @else
                         <img src="{{ url('avatar/dflt.jpg') }}" height="250" width="100%">
                        <em> size: {{ $d->size?$d->size:'null' }}</em>
                       @endif
                     <br>
                   <a href="{{ route('edit_photo', $d->id) }}" class="btn btn-info btn-sm pull-left" style="margin-right: 3px;">Edit</a>
                  {!! Form::open(['method' => 'DELETE','route' => ['delete_photo', $d->id],'style'=>'display:inline' ]) !!}
                 {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm','onclick' => 'return confirm("Are you sure u want to delete this item?");']) !!}
                {!! Form::close() !!}
              </div>
            @endforeach
          @else
      <h4>No photo to display!!!</h4>
    @endif
  </div>
 <br><br>
</div>
@endSection