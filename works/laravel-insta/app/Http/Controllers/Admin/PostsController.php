<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    // Display all posts
    public function index()
    {
        $all_posts = $this->post->latest()->paginate(10);

        return view('admin.posts.index')
            ->with('all_posts', $all_posts);
    }

    // Hide/Unhide the post
    public function updateStatus($id)
    {
        $post = $this->post->findOrFail($id);

        // Toggle the admin (hidden) flag
        $post->admin = !$post->admin;

        $post->save();

        return redirect()->back();
    }
}