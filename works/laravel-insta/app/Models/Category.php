<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];


    #to get how many posts does the category have
    #soon in admin
      public function categoryPost(){
            return $this->hasMany(CategoryPost::class);
            
            //SELECT * FROM category_post WHERE category_id = ?;
        }
}
