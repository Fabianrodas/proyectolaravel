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
        'user', 'posts', 'likedPosts',
        'postCount', 'followerCount', 'followingCount'
    ));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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
        'user', 'posts', 'likedPosts',
        'postCount', 'followerCount', 'followingCount'
    ));
}

}
