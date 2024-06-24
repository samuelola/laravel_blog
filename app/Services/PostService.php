<?php 

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class PostService{

    public function createPost(array $postData){
        $BlogPost = BlogPost::create([
            'title' => $postData['title'],
            'content' => $postData['content'],
            'thumbnail' => $postData['thumbnail'],
            'user_id'  => $postData['user_id']
        ]);

        return $BlogPost;

    }

    public function uploadImage(Request $request,$blogPost){

         if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails'); //this allows you to save in a folder
            $blogPost->image()->save(
                // to associate the image with the blog post
                Image::make(['path'=>$path])
            );
        }

        return true;
    }

    public function updatePost(Request $request, $post){

        $post->update($request->validated());
        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');
            if($post->image){
                //get and delete the old file
                Storage::delete($post->image->path);
               //if the file has an image , modify to the new one
               $post->image->path = $path;
               $post->image->save();
            }else{
                //store a new image
                $post->image()->save(
                    // to associate the image with the blog post
                    Image::make(['path'=>$path])
                );
            }
            
        }

        return $post;
    }
}