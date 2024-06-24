<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class UserService {
    
    public function updateUserImage(Request $request,$user){

        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatars');
            if($user->image){
                //get and delete the old file
                Storage::delete($user->image->path);
             //if the file has an image , modify to the new one
               $user->image->path = $path;
               $user->image->save();
            }else{
                //store a new image
                $user->image()->save(
                    // to associate the image with the blog post
                    Image::make(['path'=>$path])
                );
            }
        }

        return true;
    }
}