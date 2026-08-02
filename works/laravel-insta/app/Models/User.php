<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes; // to allow soft deletes
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    #To get all the posts of a user
    public function posts(){
        return $this->hasMany(Post::class);

        //user id 2 
        //SELECT * FROM posts WHERE user-id =2;
    }

    #To get all the followers of a user
    public function followers(){
        return $this->hasMany(Follow::class,'following_id');

        //SELECT * FROM follows WHERE following_id = 2;
    }

    #To get all the users that the user is following
    public function following(){
    return $this->hasMany(Follow::class,'follower_id');

    }

    #return True if the AUTH user is following a user
    public function isFollowed(){
        return $this->followers()->where('follower_id',Auth::user()->id)->exists();
        //Auth::user()->id is the folllower_id
        //irstly, get all the followers of the User($this->followers())
        //Then, from the list, serch for the Auth user from the follower column (where('follower_id',Auth::user->id))

        //SELECT * FROM followers WHERE folllower_id = Auth::user()->id;
    }
}
