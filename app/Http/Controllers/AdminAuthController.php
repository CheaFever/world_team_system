<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // បង្ហាញទំព័រ Register
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    // ដំណើរការចុះឈ្មោះ Admin ថ្មី រួច redirect ទៅកាន់ទំព័រ Login
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:admins,username',
            'gender'    => 'nullable|in:male,female,other',
            'dob'       => 'nullable|date',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'full_name' => $validated['full_name'],
            'username'  => $validated['username'],
            'gender'    => $validated['gender'] ?? null,
            'dob'       => $validated['dob'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'address'   => $validated['address'] ?? null,
            'password'  => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.login')->with('success', 'Registration successful! Please login.');
    }

    // បង្ហាញទំព័រ Login
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // ដំណើរការ Login តាម Username & Password
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ])->onlyInput('username');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // Dashboard បន្ទាប់ពី Login ជោគជ័យ
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}