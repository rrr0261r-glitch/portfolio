<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    protected $table = 'category_post'; //define the pivot table.
    protected $fillable = ['category_id', 'post_id']; //define the fillable columns
    public $timestamps = false;//to stop timestamps.

    #to get the name of category
    public function category(){
        return $this->belongsTo(Category::class);

        //SELECT * FROM categories WHERE id = ?;
        //[Soon] in admin

        }
    }

