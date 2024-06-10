<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('bootstrap.css')}}">
</head>
<body>
    
    <form method="post" action="{{route('logout')}}">
        @csrf
        <input type="submit" value="Logout" name="logout"/>
    </form>
    <a href="{{route('posts.create')}}">create Post</a>
    ({{Auth::user()->name ?? ''}})
    @yield('content')
  
<script src="{{asset('bootstrap.min.js')}}"></script>
</body>
</html>