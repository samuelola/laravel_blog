@extends('layouts.app')

@section('title')

@section('content')
   
         <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
         @csrf
         @include('posts.partials.form')
         <div><input type="submit" name="Create" value="Create"/></div>
         </form>
      

@endsection