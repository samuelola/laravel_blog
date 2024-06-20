<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\BlogPostPosted;
use App\Models\User;
use App\Jobs\ThrottledMail;
use App\Mail\BlogPostAdded;

class NotifyAdminWhenBlogPostCreated
{
    

    /**
     * Handle the event.
     */
    public function handle(BlogPostPosted $event): void
    {
        User::thatIsAnAdmin()->get()
              ->map(function(User $user){
                 ThrottledMail::dispatch(new BlogPostAdded (), $user);
              });
    }
}
