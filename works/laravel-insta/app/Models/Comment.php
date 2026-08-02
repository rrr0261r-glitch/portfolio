<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //to get the info of the owner of the comment
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
        
        //comment id 2 has user id 2
        //SELECT * FROM users WHERE id = 2;
    }
}
