<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\StoreComment;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;

class PostCommentController extends Controller
{
    public function store (BlogPost $post, StoreComment $request){

         $comment = $post->comments()->create([
             'content' => $request->input('content'),
             'user_id' => $request->user()->id
          ]);

         //First method also add implement queue ShouldQueue
        //   Mail::to($post->user)->send(
        //       new OrderComment($comment)
        //   );

        //Second method automatic 
          // Mail::to($post->user)->queue(
          //     new OrderComment($comment)
          // );
          
          ThrottledMail::dispatch(new OrderComment($comment), $post->user)->onQueue('high');
          NotifyUsersPostWasCommented::dispatch($comment)->onQueue('low');

        //Third method

        // $when = now()->addMinutes(1);
        //   Mail::to($post->user)->later(
        //       $when,
        //       new OrderComment($comment)
        //   );

          return redirect()->back()->withStatus('Comment was created!');
    }
}
