<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $visibleUserIds = User::where('is_private', false)
    ->orWhereHas('followers', function ($query) use ($user) {
        $query->where('follower_id', $user->id)
              ->where('status', 'accepted');
    })
    ->orWhere('id', $user->id)
    ->pluck('id');


    $recentPosts = Post::whereIn('user_id', $visibleUserIds)
        ->with(['user', 'likes', 'comments'])
        ->withCount(['likes', 'comments'])
        ->latest()
        ->get();

    $popularPosts = Post::whereIn('user_id', $visibleUserIds)
        ->with(['user', 'likes', 'comments'])
        ->withCount(['likes', 'comments'])
        ->orderByDesc('likes_count')
        ->take(20)
        ->get();

    return view('projects.home', compact('recentPosts', 'popularPosts'));
}
}