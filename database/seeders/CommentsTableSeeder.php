<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $posts = BlogPost::all();
        
        if($posts->count() === 0){
           $this->command->info('There are no blogpost, so comments will not be added!');
           return;
        }
        $CommentCount = (int)$this->command->ask('How many comments would you like?',150);
        Comment::factory($CommentCount)->make()->each(function($comment) use ($posts){

            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
       });
    }
}
