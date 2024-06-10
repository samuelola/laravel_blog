
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
      @auth
        @can('update', $post)  
        <a class="btn" href="{{route('posts.edit',$post)}}">Edit Post</a> | <a class="btn" href="{{route('posts.show',$post)}}">View Post</a>
        @endcan
      @endauth  
      
    @endforeach

    @else
      <p>There is no blog post</p>
    @endif
    
    <div>
    <p>Most Commented Post</p>
         @foreach($mostcommented as $post)
            
            <a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a>
         @endforeach
    </div>
    
    <div>
    <p>Most Active User</p>
         @foreach($MostActive as $user)
            {{$user->name}}
           
         @endforeach
    </div>
    <div>
    <p>Most Active User Lastmont</p>
         @foreach($mostActiveLastMonth as $user)
            {{$user->name}}
           
         @endforeach
    </div>
@endsection