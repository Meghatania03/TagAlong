<?php

namespace App\Http\Controllers;

use App\Models\users;
use App\Http\Requests\StoreusersRequest;
use App\Http\Requests\UpdateusersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function showSignupForm()
    {
        return view('signup');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   // Handle form submission
public function store(Request $request)
{
    // Validate input\
   

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed|min:6',
        'gender' => 'required|string',
        'age' => 'required|integer|min:18',
        'phone' => 'nullable|string',
        'bio' => 'nullable|string',
        'profile_picture' => 'nullable|image|max:2048',
        'location' => 'required|string',
        'interests' => 'nullable|array|max:3',
        'interests.*' => 'string',
        'social_links' => 'nullable|array',
        'social_links.*' => 'nullable|url'
    ]);

    // Handle profile picture
    $profilePicturePath = null;
    if ($request->hasFile('profile_picture')) {
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
    }

    // Create user
    Users::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // <-- Hash the password
        'gender' => $request->gender,
        'age' => $request->age,
        'phone' => $request->phone,
        'bio' => $request->bio,
        'profile_picture' => $profilePicturePath,
        'location' => $request->location,
        'interests' => $request->interests ? json_encode($request->interests) : null,
        'social_links' => $request->social_links ? json_encode($request->social_links) : null,
    ]);



    return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
}

    /**
     * Display the specified resource.
     */
    public function show(users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateusersRequest $request, users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(users $users)
    {
        //
    }


 // Show login page
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt login
        if (auth::attempt($credentials)) {
            $request->session()->regenerate(); // prevent session fixation
            return redirect()->intended(route('dashboard'));
        }

        // Login failed
        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }

    // Example dashboard after login
    public function dashboard()
    {
        return view('dashboard'); // Create a simple dashboard.blade.php
    }
}


