<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['title','content'];

    public function comments(){

        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

       
    // deleting a foreign key relation
    public static function boot(){

        parent::boot();

        //this delete the comments of the post
        static::deleting(function (BlogPost $blogPost){
            
            $blogPost->comments()->delete();  
        });

        static::restoring(function (BlogPost $blogPost){

            $blogPost->comments()->restore();
        });
    }
}