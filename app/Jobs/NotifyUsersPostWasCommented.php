<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentPostedOnPostWatch;

class NotifyUsersPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $now = now();
        // User::thatHasCommentedOnPost($this->comment->commentable)
        //       ->get()
        //       ->filter(function (User $user){
        //           return $user->id == $this->comment->user_id;
        //       })->map(function (User $user) use ($now){
        //           Mail::to($user)->later(
        //             $now->addSeconds(6),
        //             new CommentPostedOnPostWatch($this->comment,$user)
        //           );
        //       });

          $now = now();
        User::thatHasCommentedOnPost($this->comment->commentable)
              ->get()
              ->filter(function (User $user){
                  return $user->id == $this->comment->user_id;
              })->map(function (User $user) use ($now){
                 ThrottledMail::dispatch(new CommentPostedOnPostWatch($this->comment,$user),$user);
                
              });    
    }
}
