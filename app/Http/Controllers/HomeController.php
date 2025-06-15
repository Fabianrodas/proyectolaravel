<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();

        $followedUserIds = $authUser->followings()
            ->wherePivot('status', 'accepted')
            ->pluck('followed_id');

        $recentPosts = Post::with('user')
            ->withCount(['likes', 'comments'])
            ->where(function ($query) use ($followedUserIds, $authUser) {
                $query->whereIn('user_id', $followedUserIds)
                    ->orWhere('user_id', $authUser->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $popularPosts = Post::with('user')
            ->withCount(['likes', 'comments'])
            ->where(function ($query) use ($followedUserIds, $authUser) {
                $query->whereIn('user_id', $followedUserIds)
                    ->orWhere('user_id', $authUser->id);
            })
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->get();

        return view('projects.home', compact('recentPosts', 'popularPosts'));
    }
}