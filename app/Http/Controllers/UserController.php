<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $user->posts()
            ->latest()
            ->withCount(['likes', 'comments'])
            ->get();

        $likedPosts = Post::whereHas('likes', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->get();

        $postCount = $user->posts()->count();
        $followerCount = $user->followers()->count();
        $followingCount = $user->followings()->count();

        return view('projects.profile', compact(
            'user',
            'posts',
            'likedPosts',
            'postCount',
            'followerCount',
            'followingCount'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('projects.settings', ['user' => auth()->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_private' => 'nullable|boolean',
        ]);

        if ($request->filled('username'))
            $user->username = $request->username;
        if ($request->filled('name'))
            $user->name = $request->name;
        if ($request->filled('bio'))
            $user->bio = $request->bio;
        if ($request->filled('password'))
            $user->password = bcrypt($request->password);
        if ($request->reset_picture == '1') {
            if ($user->image !== 'storage/images/default.jpg') {
                \Storage::disk('public')->delete($user->image);
            }
            $user->image = 'storage/images/default.jpg';
        } elseif ($request->hasFile('image')) {
            if ($user->image !== 'storage/images/default.jpg') {
                \Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('profiles', 'public');
            $user->image = 'storage/' . $path;
        }

        $user->is_private = $request->boolean('is_private', false);

        $user->save();

        return back()->with('success', 'Settings updated!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();
        Auth::logout();

        if ($user->image !== 'storage/images/default.jpg') {
            \Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect('/login')->with('message', 'Your account has been deleted.');
    }


    public function showProfile()
    {
        $user = Auth::user();

        $posts = $user->posts()
            ->latest()
            ->withCount(['likes', 'comments'])
            ->get();

        $likedPosts = $user->likedPosts()->latest()->get();

        $postCount = $user->posts()->count();
        $followerCount = $user->followers()->count();
        $followingCount = $user->followings()->count();

        return view('projects.profile', compact(
            'user',
            'posts',
            'likedPosts',
            'postCount',
            'followerCount',
            'followingCount'
        ));
    }

}
