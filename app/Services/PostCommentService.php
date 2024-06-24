<?php 

namespace App\Services;

use Illuminate\Http\Request;
use App\Events\CommentPosted;
use App\Traits\LoggingTrait;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Gate;

class PostCommentService 
{
    use LoggingTrait;

    public function postComment(Request $request, BlogPost $post){
        $comment = $post->comments()->create([
             'content' => $request->input('content'),
             'user_id' => $request->user()->id
          ]);
        $message = $comment->commentable->user->name.' commented on a post at '. $comment->created_at;
        $this->report($message); 
        event(new CommentPosted($comment));
        return $comment;  
    }

    public function updatePostComment(Request $request){
        
        Gate::authorize('update', $comment);
        $comment->content = $request->input('content');
        $comment->save();
        return $comment;
    }
}