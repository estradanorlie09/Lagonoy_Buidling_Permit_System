<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ZoningController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\OboController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\PasswordResetSuccess;

// Route::get('/whoami', function () {
//     return Auth::check() ? Auth::user() : 'Not logged in';
// });
// page controller
Route::get('/', [PageController::class, 'homepage'])->name('homepage');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/signup', [PageController::class, 'signup'])->name('signup');

// Auth Controller
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');

// Applicant
Route::middleware(['auth','verified', 'role:applicant'])->group(function () {
    Route::get('/applicant/dashboard', function () {
        return view('applicant.dashboard');
    })->name('applicant.dashboard');

    Route::get('/applicant/records', [ApplicantController::class, 'records'])->name('applicant.records');
    Route::get('/applicant/form', [ApplicantController::class, 'form'])->name('applicant.forms.form');

    Route::post('/store', [ZoningController::class, 'store'])->name('zoning.store')->middleware('auth');
    Route::get('/applicant/zoning/view_application/{id}', [ZoningController::class, 'show'])->name('applicant.zoning.zoning_application_view');

    Route::get('/applicant/zoning', [ApplicantController::class, 'zoning_page'])->name('applicant.zoning.zoning_page');
    Route::get('/applicant/zoning_form', [ApplicantController::class, 'zoning_form'])->name('applicant.forms.zoning.zoning_form');
    Route::get('/applicant/schedule', [ApplicantController::class, 'schedule'])->name('applicant.calendar.schedule');
    Route::get('/applicant/setting', [ApplicantController::class, 'setting'])->name('applicant.setting');
    Route::get('/applicant/permit', [ApplicantController::class, 'permit'])->name('applicant.permit');

    Route::get('/applicant/safety_clearance', [ApplicantController::class, 'safety'])->name('applicant.safety');


    Route::get('/applicant/update_profile', [ApplicantController::class, 'update_profile'])->name('applicant.forms.profile.update_form');
    Route::post('/update_user', [FormController::class, 'update_user_profile'])->name('update_user_profile');
    Route::post('/location/municipalities', [ApplicantController::class, 'getMunicipalities']);
    Route::post('/location/barangays', [ApplicantController::class, 'getBarangays']);

    Route::get('/applicant/zoning/view_application/resubmit/{id}', [ZoningController::class, 'resubmit'])->name('applicant.zoning.zoning_application_view.resubmit_doc');
    Route::post('/resubmit/{id}', [ZoningController::class, 'doc_resubmit'])->name('zoning.resubmit')->middleware('auth');

    Route::get('/applicant/visitations/events', [ApplicantController::class, 'getVisitationEvents'])
    ->name('applicant.visitations.events');


      // pdf
    Route::get('/zoning/pdf/{id}', [PdfController::class, 'applicationReport'])->name('obo.pdf');
});

// OBO
Route::middleware(['auth', 'role:obo'])->group(function () {
    Route::get('/obo/dashboard', function () {
        return view('obo.dashboard');
    })->name('obo.dashboard');

    Route::get('/obo/zoning_records', [OboController::class, 'zoning_records'])->name('obo.zoning_records');
    Route::post('/obo/zoning/{id}/approve', [OboController::class, 'approve'])->name('obo.zoning.approve');
    Route::post('/obo/zoning/{id}/disapprove', [OboController::class, 'disapprove'])->name('obo.zoning.disapprove');
    Route::post('/obo/zoning/{id}/resubmit', [OboController::class, 'resubmit'])->name('obo.zoning.resubmit');
    Route::get('/obo/zoning/view_application_data/{id}', [OboController::class, 'show'])->name('obo.zoning.zoning_view_record');
    Route::get('/obo/zoning_schedule', [OboController::class, 'schedule'])->name('obo.zoning_schedule');
   
    Route::post('/obo/zoning/{id}/set_schedule', [OboController::class, 'scheduleVisit'])->name('obo.zoning.schedule')->middleware('auth');
    Route::post('/obo/zoning/{id}/reschedule', [OboController::class, 'reschedule'])->name('obo.zoning.reschedule');
    Route::put('/visitations/{id}/status', [OboController::class, 'updateStatus'])->name('visitations.updateStatus');


    // Route::put('/visitations/{id}/status', [OboController::class, 'cancel'])->name('schedules.cancel');

  
});

// logout
Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'admin_dashboard']);



Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); 

    return redirect()->route('login')->with('success', 'Your email has been verified. Please log in.');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/forgot-password', function () {
    return view('auth.forgot_password');
})->name('password.request');


Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');


Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset_password', ['token' => $token]);
})->name('password.reset');


Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) use ($request) {
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->setRememberToken(Str::random(60));

            $user->save();

            $user->notify(new PasswordResetSuccess());
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');

 Route::get('/certificate/{id}/verify', [PdfController::class, 'verify'])->name('certificate.verify');