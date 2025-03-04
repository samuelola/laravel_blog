<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
    use RefreshDatabase;
    public function test_no_blog_post_when_nothing_in_database(): void
    {
        $response = $this->get('/posts');
        $response->assertSeeText('There is no blog post');
    }

  

    public function test_store_valid(){
        
        $userdetails = $this->user();
        $post = $this->dummyBlogPost($userdetails->id);
        $params = [
            'title' => 'A new title for blog post change',
            'content' => 'A new Content for blog post',
            'thumbnail' => 'tuuuur.png'
        ];
        $response = $this->actingAs($userdetails)
             ->post('/posts',$params)
             ->assertStatus(302);
        
        

        // $this->post('/posts',$params)
        //      ->assertStatus(302)
        //      ->assertSessionHas('status');     

        //$this->assertEquals(session('status'),'The Blog Post was created!');     
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

        $userdetails = $this->user();
        $post = $this->dummyBlogPost($userdetails->id);
        $params = [
            'title' => 'A new title for blog post change',
            'content' => 'A new Content for blog post',
            'thumbnail' => 'tuuuur.png'
        ];


        $this->actingAs($userdetails)
             ->put("/posts/{$post->id}",$params)
             ->assertStatus(302); 
        
        

        //$this->assertEquals(session('status'),'Blog Post Updated!');      
        
        //this is to check if the title and content has been modified
        // $this->assertDatabaseMissing('blog_posts',[
        //     'title' => 'New Title',  
        // ]);

        //this is to check if the datatbase has new title and content 
        // $this->assertDatabaseHas('blog_posts',[
        //     'title' => 'A new title for blog post change',
        // ]);

        

    }

    public function test_delete(){

        $userdetails = $this->user();
        $post = $this->dummyBlogPost();
        $this->actingAs($userdetails)
             ->delete("/posts/{$post->id}")
             ->assertStatus(302);

                    
            

        //$this->assertEquals(session('status'),'Blog Post has been deleted!');  
        
        //this is to check if the title and content has been modified
        // $this->assertDatabaseMissing('blog_posts',[
        //     'title' => 'New Title',  
        // ]);

        //$this->assertSoftDeleted('blog_posts',$post->toArray());
    }

    

    
}
