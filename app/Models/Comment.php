<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['content','user_id'];

    public function commentable(){

        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $query){

        return $query->orderBy(static::CREATED_AT,'desc');
    }

    
}
