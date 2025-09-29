<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Try to authenticate with email, password, and is_admin flag
        $credentials['is_admin'] = true;

        if (Auth::guard('admin')->attempt($credentials)) {
            // Check if the authenticated user is actually an admin (defense in depth)
            $user = Auth::guard('admin')->user();

            if ($user && $user->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                // User exists but is not an admin, logout and show error
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Access denied. User is not an admin.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
