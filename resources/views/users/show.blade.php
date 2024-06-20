@extends('layouts.app')

@section('content')
   @if(session('status'))
      <p style="color:green">{{session('status')}}</div>
   @endif 
   <div class="container">
        <div class="row">
            <div class="col-md-4">
            
            @if (empty($user->image->path))
             {{"No Image"}}
            @else
             <img style="width:78px;height:78px;" src="{{$user->image->url()}}" alt="Image">
            @endif
               
            </div>
            <div class="col-md-8">
                <h3>{{$user->name}}</h3>
            </div>
        </div>
    <div>    
        

        
   
@endsection