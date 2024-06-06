<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\BlogPost;
use App\Policies\BlogPostsPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
           'App\Models\BlogPost' => BlogPostsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    //     Gate::define('update-post',function($user,$post){
    //          return $user->id == $post->user_id;
    //     });

    //     Gate::define('delete-post',function($user,$post){
    //         return $user->id == $post->user_id;
    //    });

       //Gate::policy(BlogPost::class,BlogPostsPolicy::class);

    // Gate::define('posts.update','App\Policies\BlogPostsPolicy@update');
    // Gate::define('posts.delete','App\Policies\BlogPostsPolicy@delete');

    //Gate::resource('posts',BlogPostsPolicy::class);

    //    Gate::before(function ($user, $ability){

    //          //this allows admin to do everything as autheticated user.
    //     //    if($user->is_admin){
    //     //         return true;
    //     //    }

    //         // this only allow admin to update post and not to delete them
    //        if($user->is_admin && in_array($ability,['update-post'])){
    //         return true;
    //        }
    //    });

    //    Gate::after(function ($user, $ability,$result){
    //         if($user->is_admin){
    //         return true;
    //         }
    //     });
    }
}
