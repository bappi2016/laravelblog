@extends('layouts.app')

@section('content')
 <h2>Posts</h2>  
 
 @if (count($posts) > 0)
    @foreach ($posts as $post)
       <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="/storage/cover_image/{{$post->cover_image}}" alt="Card image cap">
            <div class="card-body">
            <p class="card-text"><h3><a href="/posts/{{$post->id}}">{{ $post->title}}</a></h3>
            <small>Written on {{$post->created_at}}
            by {{$post->user->name}} </small></p>
            </div>
            </div>     
    @endforeach
    {{$posts->links()}}
     
 @else
     <p>No Posts Found</p>
 @endif
@endsection