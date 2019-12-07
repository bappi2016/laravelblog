@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-primary">Go Back</a>
 
 {{-- for read post --}}
 <h1>{{$post->title}}</h1>

 <div>
       <img class="card-img-top" src="/storage/cover_image/{{$post->cover_image}}" alt="Card image cap">
</div>


 <div>
        {{$post->body}}
 </div>

 <hr>
 <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>

{{-- edit post --}}
<hr>
@if(!Auth::guest())
       @if(Auth::user()->id == $post->user_id)
              <a href="/posts/{{$post->id}}/edit" class="btn btn-info">Edit</a>

              {!! Form :: open(['action' =>['PostController@destroy',$post->id],'method' =>'POST','class' => 'float-right']) !!}
              {{Form::hidden('_method','DELETE')}}
              {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
              {!! Form::close() !!}
       @endif
@endif
 

 
@endsection