<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //A post belongs to a user
    //To get the owner of the post
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();

        //SELECT * FROM users WHERE id = ?;
    }

    #To get the categories under a post
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);

        //SELECT * FROM category_post WHERE post_id = ?;
    }

    #To get all the comments of a post.
    public function comments(){
        return $this->hasMany(Comment::class);

        //post id 2
        //SELECT * FROM comments WHERE post-id = 2;
    }

     #To get the likes of a post
    public function likes(){
        return $this->hasMany(Like::class);

        //SELECT * FROM likes WHERE post-id =3
    }

    #returns true if the Auth user already liked the post
    public function isLiked(){
        return $this->likes()->where('user_id',Auth::user()->id)->exists();
        //exists() will check if whether at least 1 record match query
    }
}
