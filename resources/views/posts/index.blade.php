
@extends('layouts.app')

@section('content')
@if(session('status'))
      <p style="color:green">{{session('status')}}</div>
   @endif
    @if($posts->count() > 0)
    @foreach ($posts as $post)
    <p class="text-muted">
      Added {{$post->created_at->diffForHumans()}}
      By {{$post->user->name}}
    </p>
        <div>Title:{{$post->title}}</div>
        @can('delete', $post)
        <div>Content:{{$post->content}}</div>
        <form action="{{route('posts.destroy',['post'=>$post->id])}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="submit" value="Delete"/>
        </form>
        @endcan
      @can('update', $post)  
      <a class="btn" href="{{route('posts.edit',$post)}}">Edit Post</a> | <a class="btn" href="{{route('posts.show',$post)}}">View Post</a>
      @endcan
    @endforeach

    @else
      <p>There is no blog post</p>
    @endif
@endsection