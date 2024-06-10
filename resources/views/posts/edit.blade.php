@extends('layouts.app')

@section('title')

@section('content')

   <form action="{{route('posts.update',['post'=>$post->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
     @include('posts.partials.form')
     <div><input type="submit" name="Update" value="Update"/></div>
   </form>

@endsection