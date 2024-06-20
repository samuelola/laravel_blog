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

            
        
            @if (empty($post->image->path))
             {{"No Image"}}
            @else
             <img style="width:300px;height:300px;" src="{{$post->image->url()}}" alt="Image">
            @endif
    </div>

    <div class="col-md-6">
    <p>Content:{{$post->content}}</p>


    <p>Added {{$post->created_at->diffForHumans()}}</p>


    <h4>Comments</h4>

    <!--add comment-->

    <form action="{{route('addcomment',['post'=>$post->id])}}" method="post">
        @csrf
       <div class="form-group">
            <label for="">Comments</label>
            <textarea class="form-control" name="content"></textarea>
        </div>
        <div class="form-group">
        <input class="btn btn-success" type="submit" name="Add Comment" value="Add Comment"/>
        </div>
    </form>

    @foreach ($post->comments as $comment)
        
        <p>{{$comment->content}} By <a style="color:blue; text-decoration:none;" href="{{route('users.show',['user'=>$comment->user->id])}}">{{$comment->user->name}}</a></p>
        <p class="text-muted">
            added {{$comment->created_at->diffForHumans()}}
        </p>
    @endforeach

    <a class="btn btn-primary btn-sm" href="{{route('posts.index')}}">View All Posts</a>
    @endsection
    </div>

    </div>     
</div>



