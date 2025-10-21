<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Http\Requests\StoreusersRequest;
use App\Http\Requests\UpdateusersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // Show signup page
    public function showSignupForm()
    {
        return view('signup');
    }

    // Show login page
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle signup form submission
    public function store(Request $request)
    {
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


        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create user
        Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Prevent session fixation
            $request->session()->put('user_id', Auth::id()); // Set user_id for custom middleware
            return redirect()->route('events.index'); // Redirect to All Events page
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout(); // Logs out the user
        $request->session()->forget('user_id'); // Remove user_id from session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function show_profile($id)
    {
        $user = Users::with('events')->findOrFail($id);
        return view('users.profile', compact('user'));
    }


    // Redirect dashboard to All Events page
    public function dashboard()
    {
        return redirect()->route('events.index');
    }

    // Placeholder methods for RESTful controller (optional)
    public function index() {}
    public function create() {}
    public function show(Users $users) {}
    public function edit(Users $users) {}
    public function update(UpdateusersRequest $request, Users $users) {}
    public function destroy(Users $users) {}
}
