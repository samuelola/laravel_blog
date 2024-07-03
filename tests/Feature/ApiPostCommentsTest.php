<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;



class ApiPostCommentsTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_new_blog_post_does_not_hav_comments()
    {
        $user_id = $this->user()->id;
        $this->dummyBlogPost($user_id);
        $this->actingAs($this->user(), 'sanctum')->getJson('/api/v1/posts/1/comments')
        ->assertStatus(200)
        ->assertJsonStructure(['data','links','meta'])
        ->assertJsonCount(0,'data');
    }

    public function test_adding_comments_when_not_authenticated()
    {
        $this->blogPost();
        $response = $this->Json('POST','/api/v1/posts/1/comments',
        
             ['content'=> 'Hello']
        )
        ->assertStatus(401);
        
    }


    public function test_adding_comments_with_invalid_data()
    {
        $this->blogPost();

        $this->actingAs($this->user(), 'sanctum')->Json('POST','/api/v1/posts/1/comments',
            []
        )
        ->assertStatus(422);
        // ->assertJson([
            
        //     'message'=>'The given data was invalid.',
        //     'errors' => [
        //         'content'=>[
        //             "The content field is required"
        //         ]
        //     ]
    
        //  ]);
        
    }

    
}
