<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach ($posts as $post)
        <div>Title:{{$post->title}}</div>
        <div>Content:{{$post->content}}</div>
        <form action="{{route('posts.destroy',['post'=>$post->id])}}" method="POST">
          @csrf
          @method('DELETE')
          <input type="submit" value="Delete"/>
        </form>
    @endforeach
</body>
</html>