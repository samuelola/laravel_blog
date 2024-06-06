@extends('layouts.app')

@section('content')
@if(session('status'))
      <p style="color:green">{{session('status')}}</div>
@endif   
<h1>Title:{{$post->title}}</h1>
<p>Content:{{$post->content}}</p>
<p>Added {{$post->created_at->diffForHumans()}}</p>
@if ((new Carbon\Carbon())->diffInMinutes($post->created_at) > 5)
    <strong>New !</strong>
@endif

<h4>Comments</h4>

@foreach ($post->comments as $comment)
    <p>{{$comment->content}}</p>
    <p class="text-muted">
        added {{$comment->created_at->diffForHumans()}}
    </p>
@endforeach

<a class="btn" href="{{route('posts.index')}}">All Posts</a>
@endsection