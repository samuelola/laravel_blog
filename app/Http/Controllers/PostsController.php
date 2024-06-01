<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Requests\StorePost;
use DB;

class PostsController extends Controller
{
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

        $posts = BlogPost::all();
        return view('posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    { 
        $post = BlogPost::create($request->validated());
        $request->session()->flash('status', 'The Blog Post was created!');
        return redirect()->route('post.show', ['post'=>$post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);
        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id)
    {
        $post = BlogPost::findOrFail($id);
        $post->update($request->validated());
        $request->session()->flash('status', 'Blog Post Updated!');
        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();
        Session()->flash('status','Blog Post has been deleted!');
        return redirect()->route('posts.index');
    }
}
