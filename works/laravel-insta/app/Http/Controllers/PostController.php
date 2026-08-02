<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this -> post    = $post;
        $this ->category = $category;
    }
    //To open create post page
    public function create(){
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories',$all_categories);
    }

    //create
    public function store(Request $request){
        #1. Validate all form data
        $request->validate([
            'category'    => 'required|array|between:1,3', //between will check the number of items in array
            'description' => 'required|min:1|max:1000',
            'image'       =>'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Save the post
        $this->post->user_id   = Auth::user()->id;
        $this->post->image     ='data:image/'. $request->image->extension().';base64,'. base64_encode
        (file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        #3. Save the categories to the category_post table
        foreach($request->category as $category){
            $category_post[] =['category_id' => $category];
       }
        $this->post->categoryPost()->createMany($category_post); //accept 2d assoc array.
    
        #4. Go back to home page
        return redirect()->route('index');
    }

    // Read (specific)
    public function show($id){
        $post = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post',$post);
    }

    #Read (edit)
    public function edit($id){
        $post = $this->post->findOrFail($id);

        #If the Auth user is NOT the owner of the post, redirect to homepage
        if(Auth::user()->id != $post->user->id){
            return redirect()->route('index');
        }

    $all_categories = $this->category->all();

    #Get all the category IDs of this post. Save in an array
    $selected_categories = [];
    foreach($post->categoryPost as $category_post){
        $selected_categories[] = $category_post->category_id;
    }

    return view('users.posts.edit')
    ->with('post',$post)
    ->with('all_categories',$all_categories)
    ->with('selected_categories', $selected_categories);
    }

    #Update
    public function update(Request $request, $id){
        $post = $this->post->findOrFail($id);

        #If the Auth user is NOT the owner of the post, redirect to homepage
        if(Auth::user()->id != $post->user->id){
            return redirect()->route('index');
        }

        #1. Validate all form data (image is not required on update)
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image'       => 'nullable|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2. Update the post. Only replace the image if a new one was uploaded
        if($request->hasFile('image')){
            $post->image = 'data:image/'. $request->image->extension().';base64,'. base64_encode
            (file_get_contents($request->image));
        }
        $post->description = $request->description;
        $post->save();

        #3. Delete all the existing categories of this post
        $post->categoryPost()->delete();

        #4. Save the new categories to the category_post table
        foreach($request->category as $category){
            $category_post[] = ['category_id' => $category];
        }
        $post->categoryPost()->createMany($category_post);

        #5. Go to the post's show page
        return redirect()->route('post.show', $post->id);
    }

    #Delete
    public function destroy($id){
        $this->post->destroy($id);
        return redirect()->route('index');
    }
    
}
