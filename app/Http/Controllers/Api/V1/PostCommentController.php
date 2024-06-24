<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Http\Requests\StoreComment;
use Illuminate\Support\Facades\Gate;
use App\Services\PostCommentService;


class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogPost $post, Request $request)
    {
       
        // return CommentResource::collection($post->comments()->with('user')->paginate(5));

        $perPage = $request->input('per_page') ?? 15;
        return CommentResource::collection(
            $post->comments()->with('user')->paginate($perPage)->appends(
                
                [
                    'per_page'=> $perPage
                ]
                
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPost $post,StoreComment $request,PostCommentService $postCommentService)
    {
        //Gate::authorize(Comment::class);
          $comment = $postCommentService->postComment($request,$post);
          return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPost $post, Comment $comment,StoreComment $request)
    {
        $comment = $postCommentService->updatePostComment($request);
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $post, Comment $comment)
    {
        Gate::authorize('delete', $post);
        $comment->delete();
        return response()->noContent();
    }
}
