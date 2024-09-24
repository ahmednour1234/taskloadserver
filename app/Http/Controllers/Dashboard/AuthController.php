<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,employee',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            toastr()->error('Please check the form for errors.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        toastr()->success('Registration successful!');
        return view('welcome');
    }

    // Login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Login a user
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            toastr()->error('Please check your login credentials.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            toastr()->error('The provided credentials are incorrect.');
            return redirect()->back()->withInput();
        }

        toastr()->success('Login successful!');
        return view('welcome');
    }

    // Logout a user
    public function logout(Request $request)
    {
        Auth::logout();

        toastr()->success('Logout successful!');
        return view('login');
        ;
    }
}

