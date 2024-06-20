<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\Image;
use App\Http\Requests\StorePost;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Services\Counter;
use App\Facades\CounterFacade;
use App\Events\BlogPostPosted;

class PostsController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //check for lazy loading code
        // DB::connection()->enableQueryLog();
        
        // $posts = BlogPost::with('comments')->get();

        // foreach($posts as $post){
        //      foreach($post->comments as $comment){
        //          echo $comment->content;
        //      }
        // }

        // dd(DB::getQueryLog());
        
        $mostCommented = Cache::remember('mostCommented', now()->addSeconds(10),function(){
            return BlogPost::MostCommented()->take(5)->get();
        });

        $MostActive = Cache::remember('MostActive', now()->addSeconds(10),function(){
            return User::MostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth', now()->addSeconds(10),function(){
            return User::WithMostBlogPostsLastMonth()->take(5)->get();
        });


        $posts = BlogPost::latest()->with('user')->get();
        return view('posts.index',[
            'posts'=>$posts,
            'mostcommented' => $mostCommented,
            'MostActive'=>$MostActive,
            'mostActiveLastMonth' => $mostActiveLastMonth
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Gate::authorize('create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    { 
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost= BlogPost::create($validatedData);
        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails'); //this allows you to save in a folder
            $blogPost->image()->save(
                // to associate the image with the blog post
                Image::make(['path'=>$path])
            );
        }

        event(new BlogPostPosted($blogPost));
       
        $request->session()->flash('status', 'The Blog Post was created!');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $post = BlogPost::with(['comments'=>function ($query){
        //     return $query->latest();
        // }])->findOrFail($id);

        $post = BlogPost::findOrFail($id);

        //this is how to add cache check the blogpost db to remove cache
        // $blogPost = Cache::remember("blog-post-{$id}", 60, function() use ($id){

        //     return BlogPost::with('comments')->findOrFail($id);
        // });

        // //get current user session id

        // $counter = resolve(Counter::class);

        return view('posts.show',[
            'post'=>$post,
            // 'counter' => CounterFacade::increment->increment("blog-post-{$id}",['blog-post'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);
        
         Gate::authorize('update',$post); 
        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id)
    {
        $post = BlogPost::findOrFail($id);
        // if(Gate::denies('posts.update',$post)){
        //    abort(403,"You can not edit this Blog Post!");
        // }
        Gate::authorize('update',$post);
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
        $request->session()->flash('status', 'Blog Post Updated!');
        //return redirect()->route('posts.show',['post'=>$post]);
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('posts.delete',$post)){
        //     abort(403,"You can not delete this Blog Post!");
        //  }

        Gate::authorize('delete',$post); 
        $post->delete();
        Session()->flash('status','Blog Post has been deleted!');
        return redirect()->route('posts.index');
    }
}
