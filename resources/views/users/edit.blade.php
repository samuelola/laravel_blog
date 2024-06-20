@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <form method="POST" enctype="multipart/form-data"
        action="{{route('users.update',['user'=>$user])}}"
        class="form-horizontal">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4">
            @if (empty($user->image->path))
             {{"No Image"}}
            @else
             <img style="width:78px;height:78px;" src="{{$user->image->url()}}" alt="Image" class="img-thumbnail avatar">
            @endif
                
                <div class="card mt-4">
                     <div class="card-body">
                         <h6>Upload a different photo</h6>
                         <input class="form-control-file" type="file" name="avatar">
                     </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="">Name</label>
                    <input class="form-control" type="text" name="name">
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Save Changes">
                </div>
            </div>
        </div>
    </form>
        </div>
    </div>
</div>
   
@endsection