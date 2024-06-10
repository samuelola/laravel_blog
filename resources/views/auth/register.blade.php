<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="{{route('register')}}">
    @csrf   
    <p>Name:<input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required></p>    
    <p>Email:<input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required></p>
    <p>Password:<input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required></p>
    <p><input type="submit" value="Submit" name="submit"/></p>
    
    </form>
   
    @guest
    <p><a href="{{route('signin')}}">Login</a></p>
    @else
    <p><a href="{{route('posts.index')}}">Posts</a></p>
    @endguest
</body>
</html>