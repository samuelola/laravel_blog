<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
    use RefreshDatabase;
    // public function test_no_blog_post_when_nothing_in_database(): void
    // {
    //     $response = $this->get('/posts');
    //     $response->assertSeeText('There is no blog post');
    // }

  

    public function test_store_valid(){
        
        $params = [
            'title' => 'Valid Title',
            'content' => 'At least 10  characters'
        ];

        //for authentication requirement
        $this->actingAs($this->user())
             ->post('/posts',$params)
             ->assertStatus(302)
             ->assertSessionHas('status');

        // $this->post('/posts',$params)
        //      ->assertStatus(302)
        //      ->assertSessionHas('status');     

        $this->assertEquals(session('status'),'The Blog Post was created!');     
    }

    public function test_store_fail(){
       
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

       //for authentication requirement
       $this->actingAs($this->user())
       ->post('/posts',$params)
       ->assertStatus(302)
       ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();  
        $this->assertEquals($messages['title'][0],'The title field must be at least 5 characters.'); 
        $this->assertEquals($messages['content'][0],'The content field must be at least 10 characters.');   
    }

    public function test_update_valid(){
        
        $user=$this->user();
        //Arrange Part
        $post = $this->dummyBlogPost($user->id);

        //check if the blog exists on the database
        // $this->assertDatabaseHas('blog_posts',$post->toArray());

        $params = [
            'title' => 'A new title for blog post change',
            'content' => 'A new Content for blog post'
        ];

        $this->actingAs($user)
             ->put("/posts/{$post->id}",$params)
             ->assertStatus(200)
             ->assertSessionHas('status'); 

        $this->assertEquals(session('status'),'Blog Post Updated!');      
        
        //this is to check if the title and content has been modified
        // $this->assertDatabaseMissing('blog_posts',[
        //     'title' => 'New Title',  
        // ]);

        //this is to check if the datatbase has new title and content 
        $this->assertDatabaseHas('blog_posts',[
            'title' => 'A new title for blog post change',
        ]);

    }

    public function test_delete(){
        
        $user=$this->user();
        $post = $this->dummyBlogPost($user->id);
        //check if the blog exists on the database
        // $this->assertDatabaseHas('blog_posts',[
        //     'title' => 'New Title',
        //     'content' => 'New content for blog post'
        // ]);
        $this->actingAs($user)
             ->delete("/posts/{$post->id}")
             ->assertStatus(302)
             ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog Post has been deleted!');  
        
        //this is to check if the title and content has been modified
        // $this->assertDatabaseMissing('blog_posts',[
        //     'title' => 'New Title',  
        // ]);

        //$this->assertSoftDeleted('blog_posts',$post->toArray());
    }

    public function dummyBlogPost($userId=null):BlogPost
    {

        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'New content for blog post';
        // $post->save();

        // return $post;

        return BlogPost::factory()->newTitle()->create(
            ['user_id'=>$userId ?? $this->user()->id]
        );
    }
}
