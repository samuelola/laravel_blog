<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\Comment;

abstract class TestCase extends BaseTestCase
{
    protected function user(){
       $user = User::factory()->make();
        $credentials = [
             'name'=>$user->name,
             'email'=>$user->email,
             'is_admin' => $user->is_admin,
             'password' => $user->password
        ];
        $userdetails = User::create($credentials);
        return $userdetails;
    }

    public function dummyBlogPost($userId=null):BlogPost
    {

        $post = new BlogPost();
        $post->title = 'New Title';
        $post->content = 'New content for blog post';
        $post->user_id = $userId;
        $post->save();

        return $post;

        // return BlogPost::factory()->newTitle()->create(
        //     ['user_id'=>$userId ?? $this->user()->id]
        // );
    }

    public function blogPost($user_id=null)
    {

        $newcomentPost = BlogPost::factory()->create([
            'user_id' => $this->user()->id
        ]);

        return $newcomentPost;

    }
}
