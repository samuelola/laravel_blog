@extends('layouts.app')

@section('content')
    <form method="POST" enctype="multipart/form-data"
        action="{{route('users.update',['user'=>$user])}}"
        class="form-horizontal">
        @csrf
        @method('PUT')
    </form>
@endsection