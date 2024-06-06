<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="{{route('logout')}}">
        @csrf
        <input type="submit" value="Logout" name="logout"/>
    </form>
    @yield('content')
</body>
</html>