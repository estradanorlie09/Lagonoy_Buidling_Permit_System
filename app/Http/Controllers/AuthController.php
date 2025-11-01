<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:applicant,obo,do,bfp',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // keeps old input
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice')->with('success', 'Account Created');
        // return redirect()->back()->with('success', 'User registered successfully!');
    }

    // login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'role' => 'required|in:applicant,obo,do,bfp,zoning_officer,sanitary_officer,professional',
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isApplicant()) {
            // dd($user);
            // dd($request);
            return redirect()->intended(route('applicant.dashboard'));
        } elseif ($user->isZoning()) {
            return redirect()->intended(route('zoning_officer.dashboard'));
        } elseif ($user->isSanitary()) {
            return redirect()->intended(route('sanitary_officer.dashboard'));
        } elseif ($user->isObo()) {
            return redirect()->intended(route('obo.dashboard'));
        } elseif ($user->isProfessional()) {
            return redirect()->intended(route('professional.dashboard'));
        } else {
            // fallback route if role doesn't match any
            Auth::logout();

            return redirect('/login')->withErrors(['role' => 'Your role is not authorized']);
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
