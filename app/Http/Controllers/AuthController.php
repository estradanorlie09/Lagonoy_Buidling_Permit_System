<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationCode;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'birth_date' => 'required|date|before:-18 years',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => [
                'required',
                'string',
                'regex:/^(09|\+639)\d{9}$/',
            ],
            'role' => 'required|in:applicant,obo,do,bfp',

            'tin_number' => [
                'required',
                'string',
                'unique:users,tin_number',
                'regex:/^\d{3}-\d{3}-\d{3}$/', // format: 123-456-789
            ],
            'tax_declaration_no' => [
                'required',
                'string',
                'unique:users,tax_declaration_no',
                'regex:/^\d{1,5}-\d{1,5}-\d{1,5}$/',
            ],

            'gov_id_file' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'tax_declaration_file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ], [
            'tax_declaration_no.regex' => 'Invalid Tax Declaration number format. Example: 12345-00123-000',
            'birth_date.before' => 'You must be at least 18 years old to register.',
            'phone.regex' => 'The phone number must be a valid Philippine number (09XXXXXXXXX or +639XXXXXXXXX).',
            'tin_number.regex' => 'TIN number format must be XXX-XXX-XXX.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // keeps old input
        }

        $govIdPath = null;
        $taxDeclPath = null;

        if ($request->hasFile('gov_id_file')) {
            $govIdPath = $request->file('gov_id_file')->store('gov_id', 'public');
        }

        if ($request->hasFile('tax_declaration_file')) {
            $taxDeclPath = $request->file('tax_declaration_file')->store('tax_declaration', 'public');
        }

        $verificationCode = mt_rand(100000, 999999);
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
            'tin_number' => $request->tin_number,
            'tax_declaration_no' => $request->tax_declaration_no,
            'gov_id_file' => $govIdPath,
            'tax_declaration_file' => $taxDeclPath,
            'email_verification_code' => $verificationCode,
            'pre_registration_status' => 'pending',
        ]);

        // event(new Registered($user));
        // Send verification code to user's email
        Mail::to($user->email)->send(new EmailVerificationCode($user));
        Auth::login($user);

        return redirect()->route('verification.notice')->with('success', 'Account Created');
        // return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function submitVerificationCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        // Check if code matches and not expired (optional: you can add expiry)
        if ($user->email_verification_code == $request->verification_code) {
            $user->email_verified_at = now();
            $user->email_verification_code = null; // Clear code after verification
            $user->save();

            return redirect()->route('applicant.dashboard')->with('success', 'Email verified successfully!');
        }

        return back()->withErrors(['verification_code' => 'Invalid verification code.']);
    }

    public function resendCode(Request $request)
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return redirect()->route($user->redirectRoute());
        }

        $user->email_verification_code = mt_rand(100000, 999999);
        $user->save();

        Mail::to($user->email)->send(new EmailVerificationCode($user));

        return back()->with('info', 'A new verification code has been sent!');
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

        // Check if email is verified
        if (! $user->email_verified_at) {
            // Generate new verification code
            $user->email_verification_code = mt_rand(100000, 999999);
            $user->save();

            // Send the code via email
            \Mail::to($user->email)->send(new \App\Mail\EmailVerificationCode($user));

            return redirect()->route('verification.notice')
                ->with('info', 'A new verification code has been sent to your email.');
        }

        if ($user->isApplicant() && $user->pre_registration_status === 'rejected') {
            session()->flash('show_rejected_modal', true);
        }

        if ($user->isApplicant() && $user->pre_registration_status === 'approved') {
            session()->flash('show_approved_modal', true);
        }

        if ($user->isApplicant() && $user->pre_registration_status === 'pending') {
            session()->flash('show_pending_modal', true);
        }
        // Redirect based on role
        if ($user->isApplicant()) {
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
            Auth::logout();

            return redirect('/login')->withErrors(['role' => 'Your role is not authorized']);
        }
    }

    // public function destroy(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return redirect('/login');
    // }

    public function destroy(Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
