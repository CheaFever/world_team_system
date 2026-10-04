<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    // បង្ហាញទំព័រ Register
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    // ដំណើរការចុះឈ្មោះ Admin ថ្មី
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:admins,username',
            'gender'    => 'nullable|in:male,female,other',
            'dob'       => 'nullable|date',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'full_name' => strip_tags($validated['full_name']),
            'username'  => trim($validated['username']),
            'gender'    => $validated['gender'] ?? null,
            'dob'       => $validated['dob'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'address'   => isset($validated['address']) ? strip_tags($validated['address']) : null,
            'password'  => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.login')->with('success', 'ចុះឈ្មោះជោគជ័យ! សូមធ្វើការ Login។');
    }

    // បង្ហាញទំព័រ Login
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // ដំណើរការ Login ជាមួយ Rate Limiter (ការពារការទាយ Password)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // កំណត់ Rate Limiting Key តាម Username និង IP Address
        $throttleKey = Str::transliterate(Str::lower($request->input('username')) . '|' . $request->ip());

        // ពិនិត្យមើលថាតើបានវាយខុសលើសកំណត់ (៥ ដង) ដែរឬទេ
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'username' => "អ្នកបានព្យាយាម Login ខុសច្រើនដងពេក។ សូមរង់ចាំ {$seconds} វិនាទីទៀតមុននឹងសាកល្បងម្ដងទៀត។",
            ]);
        }

        // ផ្ទៀងផ្ទាត់ការ Login តាមរយៈ Guard admin
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            // សម្អាត Rate Limiter ពេល Login ជោគជ័យ
            RateLimiter::clear($throttleKey);

            // បង្កើត Session ID ថ្មីដើម្បីការពារ Session Fixation Attack
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // រាប់ចំនួនដងនៃការ Login បរាជ័យ (កំណត់រយៈពេលចាក់សោ ៦០ វិនាទី)
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'username' => 'ឈ្មោះគណនី ឬពាក្យសម្ងាត់មិនត្រឹមត្រូវឡើយ!',
        ])->onlyInput('username');
    }

    // បង្ហាញ Dashboard (មាន Header ការពារ Cache មិនឱ្យ Back ឃើញ)
    public function dashboard()
    {
        return response()
            ->view('admin.dashboard')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }

    // Logout និងកម្ទេច Session ចោលទាំងស្រុង
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        // សម្អាត Session ទិន្នន័យចាស់ទាំងអស់
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'អ្នកបានចាកចេញដោយជោគជ័យ!');
    }
    // បង្ហាញទំព័រ Profile របស់ Admin
    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    // ដំណើរការកែប្រែព័ត៌មាន Profile
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:admins,username,' . $admin->id,
            'phone'     => 'nullable|string|max:20',
            'gender'    => 'nullable|in:male,female,other',
            'dob'       => 'nullable|date',
            'address'   => 'nullable|string|max:500',
            'password'  => 'nullable|string|min:6|confirmed', // វាយលុះត្រាតែចង់ប្តូរ Password ថ្មី
        ]);

        $admin->full_name = strip_tags($validated['full_name']);
        $admin->username  = trim($validated['username']);
        $admin->phone     = $validated['phone'] ?? null;
        $admin->gender    = $validated['gender'] ?? null;
        $admin->dob       = $validated['dob'] ?? null;
        $admin->address   = isset($validated['address']) ? strip_tags($validated['address']) : null;

        // បើមានបញ្ចូល Password ថ្មី ទើបធ្វើការ Update
        if ($request->filled('password')) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return back()->with('success', 'ព័ត៌មាន Profile ត្រូវបានកែសម្រួលជោគជ័យ!');
    }
}
