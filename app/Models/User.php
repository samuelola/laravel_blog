<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function blogpost(){
        return $this->hasMany(BlogPost::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function commentsOn(){

        return $this->morphMany(Comment::class,'commentable');
    }

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }


    public function scopeMostBlogPosts(Builder $query)
    {
       return $query->withCount('blogpost')->orderBy('id','desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
       return $query->withCount(['blogpost'=>function(Builder $query){
           $query->whereBetween(static::CREATED_AT,[now()->subMonths(1), now()]);
       }])
       ->has('blogpost','>=',2)
       ->orderBy('id','desc');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post){

        return $query->whereHas('comments', function($query) use ($post){
            return $query->where('commentable_id', '=', $post->id)
                         ->where('commentable_type', '=', BlogPost::class);
         });
    }

    //this returns all the users that are admin
    public function scopeThatIsAnAdmin(Builder $query){
       return $query->where('is_admin',true);
    }
   
}
