<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('projects.register');
    }

    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'The name field is required.',
            'username.required' => 'The username field is required.',
            'email.required' => 'The email field is required.',
        ];

        $requiredFields = ['name', 'username', 'email'];

        $missing = [];

        foreach ($requiredFields as $field) {
            if (!$request->filled($field)) {
                $missing[] = $field;
            }
        }

        if (count($missing) > 1) {
            return back()->withErrors(['general' => 'There are multiple required fields missing.'])->withInput();
        }

        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_private' => 'nullable|boolean',
        ];

        $request->validate($rules, $messages);

        $imagePath = '/storage/images/default.jpg';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            $imagePath = '/storage/images/' . $filename;
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'is_private' => $request->boolean('is_private'),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
}
