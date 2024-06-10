<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\DeletedAdminScope;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['title','content','user_id'];

    public function comments(){

        return $this->hasMany(Comment::class)->latest();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $query){

        return $query->orderBy(static::CREATED_AT,'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
       return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    

       
    // deleting a foreign key relation
    public static function boot(){

        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        //this delete the comments of the post
        static::deleting(function (BlogPost $blogPost){
            
            $blogPost->comments()->delete();  
        });
 
        //this is how to remove cache
        static::updating(function (BlogPost $blogpost){
            Cache::forget("blog-post-{$blogpost->id}");
        });

        static::restoring(function (BlogPost $blogPost){

            $blogPost->comments()->restore();
        });
    }
}