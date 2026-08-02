<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return view('users.profile.show')->with('user',$user);
    }
    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);

        return view('users.profile.edit')->with('user',$user);
    }

    public function update(Request $request){
        $request->validate([
            'name'           => 'required|min:1|max:50',
            'email'          => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar'         => 'mimes:jpeg,jpg,gif,png|max:1048',
            'introduction'   =>'max:100'
        ]);

        #2. Update the user
        $user                = $this->user->findOrFail(Auth::user()->id);
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->introduction = $request->introduction;

        # If there is a new avatar  
        if($request->avatar){
            $user->avatar = 'data:image/'. $request->avatar->extension().';base64,'. base64_encode
        (file_get_contents($request->avatar));;
        }

        #3. Save
        $user->save();

        #4. Redirect
        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function followers( $id){
        $user = $this->user->findOrFail($id);

        return view('users.profile.followers')->with('user',$user);
    }

     public function following( $id){
        $user = $this->user->findOrFail($id);

        return view('users.profile.following')->with('user',$user);
    }

    public function suggested(){
        $user = $this->user->findOrFail(Auth::user()->id);

        $followingIds = Auth::user()->following()->pluck('following_id');

        $suggested_users = $this->user
            ->where('id', '!=', Auth::user()->id)
            ->whereNotIn('id', $followingIds)
            ->get();

        return view('users.profile.suggested')
            ->with('user', $user)
            ->with('suggested_users', $suggested_users);
    }
}
