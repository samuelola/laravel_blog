<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('bootstrap.css')}}">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <h2>Register</h2>
                <form method="POST" action="{{route('register')}}">
                @csrf  
                <div class="form-group">
                    <label for="">Name</label>
                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                </div> 
                <div class="form-group">
                    <label for="">Email</label>
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>
                </div>
                <div class="form-group">
                <input type="submit" value="Register" name="submit"/>
                </div>
                
                
                </form>
                @guest
                <p><a style="color:#000;" href="{{route('signin')}}">Login</a></p>
                @else
                <p><a style="color:#000;" href="{{route('posts.index')}}">Posts</a></p>
                @endguest
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    
   
   

    <script src="{{asset('bootstrap.min.js')}}"></script>
</body>
</html>