<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{   
    private $post;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $home_posts = $this->getHomeposts();
        $suggested_users = $this->getSuggestedUsers();
            return view('users.home')
            ->with('home_posts',$home_posts)
            ->with('suggested_users',$suggested_users);
    }

    #Get the posts of the users that the Auth use is following
    private function getHomePosts(){
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id == Auth::user()->id){
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    }
    
    #Get all the users that Auth user is NOT Following
    private function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users,0,5);
        //array_slice(x,y,z)
        //x--array
        //y--offset/
        //z--length

    }
}
