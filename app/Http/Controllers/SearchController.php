<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}
