<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CommentPosted;
use App\Mail\OrderComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;

class NotifyUserAboutComment
{
   
    /**
     * Handle the event.
     */
    public function handle(CommentPosted  $event): void
    {
        // dd("i was called by an event");
        ThrottledMail::dispatch(new OrderComment($event->comment), $event->comment->commentable->user);
        NotifyUsersPostWasCommented::dispatch($event->comment);
    }
}
