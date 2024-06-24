<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\StoreComment;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\OrderComment;
// use App\Jobs\NotifyUsersPostWasCommented;
// use App\Jobs\ThrottledMail;
// use App\Traits\LoggingTrait;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Gate;
use App\Services\PostCommentService;

class PostCommentController extends Controller

{

    public function index(BlogPost $post){
        
      // dump(is_array($post->comments));
      // dump(get_class($post->comments));
      // die();
        // return $post->comments;
        //return new CommentResource($post->comments->first());
        return CommentResource::collection($post->comments()->with('user')->get());
        //return $post->comments()->with('user')->get();
    }

    public function store (BlogPost $post, StoreComment $request, PostCommentService $postCommentService){
        
        $postCommentService->postComment($request,$post);
          

         //First method also add implement queue ShouldQueue
        //   Mail::to($post->user)->send(
        //       new OrderComment($comment)
        //   );

        //Second method automatic 
          // Mail::to($post->user)->queue(
          //     new OrderComment($comment)
          // );

         
          
          // ThrottledMail::dispatch(new OrderComment($comment), $post->user);
          // NotifyUsersPostWasCommented::dispatch($comment);

        //Third method

        // $when = now()->addMinutes(1);
        //   Mail::to($post->user)->later(
        //       $when,
        //       new OrderComment($comment)
        //   );

          return redirect()->back()->withStatus('Comment was created!');
    }
}
