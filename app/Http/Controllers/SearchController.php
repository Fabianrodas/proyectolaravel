<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $users = [];

        if ($query) {
            $users = User::where('username', 'like', "%$query%")
                ->orWhere('name', 'like', "%$query%")
                ->get();
        }

        return view('projects.search', compact('users', 'query'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->input('query');
        $users = [];

        if ($query) {
            $users = User::where('username', 'like', "%$query%")
                ->orWhere('name', 'like', "%$query%")
                ->limit(5)
                ->get();
        }

        return response()->json($users->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'image' => asset(ltrim($user->image, '/')),
            ];
        }));

    }

}
