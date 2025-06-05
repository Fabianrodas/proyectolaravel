<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = Post::with('user')
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();

        $popularPosts = Post::with('user')
            ->withCount(['likes', 'comments'])
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->get();

        return view('projects.home', compact('recentPosts', 'popularPosts'));
    }
}