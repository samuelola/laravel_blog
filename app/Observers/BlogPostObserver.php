<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
     //this is how to remove cache
    public function updating(BlogPost $blogPost): void
    {
       Cache::forget("blog-post-{$blogpost->id}");
    }

    //this delete the comments of the post
    public function deleting (BlogPost $blogPost){
         //dd('Deleting test');
         $blogPost->comments()->delete();  
    }

    public function restoring(BlogPost $blogPost): void
    {
         $blogPost->comments()->restore();
    }

    
}
