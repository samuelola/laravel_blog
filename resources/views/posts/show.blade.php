@extends('layouts.app')

@section('content')
@if(session('status'))
      <p style="color:green">{{session('status')}}</div>
@endif  

<div class="container">
    <div class="row">

    <div class="col-md-6">
            <p>Title:{{$post->title}}</p>
            <h3>
            @if ((new Carbon\Carbon())->diffInMinutes($post->created_at) < 25)

                <x-badge type="primary" show="false">
                    New !
                </x-badge>
            @endif

            </h3>

            @if ($post->image)

            <img style="width:300px;height:300px;" src="{{$post->image->url()}}" alt="Image">
            @else

            @endif
    </div>

    <div class="col-md-6">
    <p>Content:{{$post->content}}</p>


    <p>Added {{$post->created_at->diffForHumans()}}</p>


    <h4>Comments</h4>

    @foreach ($post->comments as $comment)
        <p>{{$comment->content}}</p>
        <p class="text-muted">
            added {{$comment->created_at->diffForHumans()}}
        </p>
    @endforeach

    <a class="btn" href="{{route('posts.index')}}">All Posts</a>
    @endsection
    </div>

    </div>     
</div>



