<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Use your User model

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Check if email exists
        $userExists = User::where('email', $request->email)->first();

        if (!$userExists) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email not found']);
        }

        // Attempt login
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // Check if role is admin (optional)
            if (Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')
                    ->with('error', 'You are not authorized to access this page.');
            }
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Password is incorrect']);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully!');
    }
}
