<?php

namespace App\Http\Controllers\frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendAuthController extends Controller
{
    public function loginShow()
    {
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6', 'max:20'],
        ]);

        // Get credentials
        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::guard('customer')->attempt($credentials)) {
            $user = Auth::guard('customer')->user();

            // Check role
            if ($user->role === 'customer') {
                return redirect()->route('frontend.dashboard')
                    ->with(['alert-type' => 'success', 'message' => 'Login Successfully.']);
            } else {
                Auth::guard('customer')->logout(); // logout non-admins
                return redirect()->back()->withErrors(["credentials" => "Not a customer"]);
            }
        }

        // Invalid credentials
        return redirect()->back()->withErrors(["credentials" => "Credentials don't match our records"]);
    }

    public function userRegisterShow()
    {
        return view('frontend.register');
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:60',
            'email' => 'required|min:5|max:40|email:rfc,dns',
            'password' => 'required|min:8|max:16|confirmed'
        ]);

        $signUp = new User();
        $signUp->name = $request->name;
        $signUp->role = 'customer';
        $signUp->email = $request->email;
        $signUp->password = Hash::make($request->password);
        if ($signUp->save()) {
            return redirect()->route('frontend.login')->with(['alert-type' => 'success', 'message' => 'Sign Up Successfully']);
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function logout()
    {
        if (Auth::guard('customer')) {
            Auth::guard('customer')->logout();
        }
        return redirect()->route('frontend.login');
    }
}
