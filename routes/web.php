<?php

use App\Http\Controllers\ApplicantBuildingPermitController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\OboController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SanitaryContoller;
use App\Http\Controllers\ZoningController;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth', 'verified', 'role:applicant'])->group(function () {
    // Route::get('/applicant/dashboard', function () {
    //     return view('applicant.dashboard');
    // })->name('applicant.dashboard');

    Route::get('/applicant/dashboard', [ApplicantController::class, 'index'])
        ->name('applicant.dashboard');

    Route::get('/applicant/form', [ApplicantController::class, 'form'])->name('applicant.forms.form');

    Route::post('/store', [ZoningController::class, 'store'])->name('zoning.store')->middleware('auth');
    Route::get('/applicant/zoning/view_application/{id}', [ZoningController::class, 'show'])->name('applicant.zoning.zoning_application_view');

    Route::get('/applicant/zoning', [ApplicantController::class, 'zoning_page'])->name('applicant.zoning.zoning_page');
    Route::get('/applicant/zoning_form', [ApplicantController::class, 'zoning_form'])->name('applicant.forms.zoning.zoning_form');
    Route::get('/applicant/schedule', [ApplicantController::class, 'schedule'])->name('applicant.calendar.schedule');
    Route::get('/applicant/setting', [ApplicantController::class, 'setting'])->name('applicant.setting');
    Route::get('/applicant/permit', [ApplicantController::class, 'permit'])->name('applicant.permit');

    Route::get('/applicant/update_profile', [ApplicantController::class, 'update_profile'])->name('applicant.forms.profile.update_form');
    Route::post('/update_user', [FormController::class, 'update_user_profile'])->name('update_user_profile');
    Route::post('/location/municipalities', [ApplicantController::class, 'getMunicipalities']);
    Route::post('/location/barangays', [ApplicantController::class, 'getBarangays']);

    Route::get('/applicant/zoning/view_application/resubmit/{id}', [ZoningController::class, 'resubmit'])->name('applicant.zoning.zoning_application_view.resubmit_doc');
    Route::post('/resubmit/{id}', [ZoningController::class, 'doc_resubmit'])->name('zoning.resubmit')->middleware('auth');

    Route::get('/applicant/visitations/events', [ApplicantController::class, 'getVisitationEvents'])
        ->name('applicant.visitations.events');

    // Sanitary
    Route::get('/applicant/sanitary', [ApplicantController::class, 'sanitary'])->name('applicant.sanitary');
    Route::get('/applicant/sanitary/sanitary_form', [SanitaryContoller::class, 'sanitary_form'])->name('sanitary.forms.sanitary.sanitary_form');
    Route::post('/store/sanitary_application', [SanitaryContoller::class, 'store'])->name('sanitary.store')->middleware('auth');
    Route::get('/applicant/sanitary/view_application/{id}', [SanitaryContoller::class, 'show'])->name('applicant.sanitary.sanitary_application_view');

    Route::get('/applicant/sanitary/view_application/resubmit/{id}', [SanitaryContoller::class, 'resubmit_doc'])->name('applicant.sanitary.sanitary_application_view.resubmit_doc');
    Route::post('/resubmit_sanitary/{id}', [SanitaryContoller::class, 'doc_resubmit'])->name('sanitary.resubmit')->middleware('auth');

    // obo
    Route::get('/applicant/building_permit', [ApplicantBuildingPermitController::class, 'buildingPermit'])->name('applicant.buildingPermit');
    Route::get('/applicant/building_permit/form', [ApplicantBuildingPermitController::class, 'buildingPermitForms'])->name('applicant.forms.obo.buidlingPermitForm');
    Route::post('/applicant/building_permit/store', [ApplicantBuildingPermitController::class, 'store'])->name('building_application.store')->middleware('auth');
    Route::get('/applicant/building_permit/view_application/{id}', [ApplicantBuildingPermitController::class, 'show'])->name('applicant.obo.building_application_view');

    Route::get('/search-applications', [ApplicantController::class, 'search'])->name('applications.search');

    // pdf
    Route::get('/zoning_doc/pdf/{id}', [PdfController::class, 'applicationReport'])->name('zoning.pdf');
    Route::get('/sanitary/pdf/{id}', [PdfController::class, 'applicationReportSanitary'])->name('sanitary.pdf');
});

// Zoning
Route::middleware(['auth', 'verified', 'role:zoning_officer'])->group(function () {
    Route::get('/zoning_officer/dashboard', function () {
        return view('zoning_officer.dashboard');
    })->name('zoning_officer.dashboard');

    Route::get('/zoning_officer/zoning_records', [OboController::class, 'zoning_records'])->name('zoning_officer.zoning_records');
    Route::post('/zoning_officer/zoning/{id}/approve', [OboController::class, 'approve'])->name('zoning_officer.zoning.approve');
    Route::post('/zoning_officer/zoning/{id}/disapprove', [OboController::class, 'disapprove'])->name('zoning_officer.zoning.disapprove');
    Route::post('/zoning_officer/zoning/{id}/resubmit', [OboController::class, 'resubmit'])->name('zoning_officer.zoning.resubmit');
    Route::get('/zoning_officer/zoning/view_application_data/{id}', [OboController::class, 'show'])->name('zoning_officer.zoning.zoning_view_record');
    Route::get('/zoning_officer/zoning_schedule', [OboController::class, 'schedule'])->name('zoning_officer.zoning_schedule');

    Route::post('/zoning_officer/zoning/{id}/set_schedule', [OboController::class, 'scheduleVisit'])->name('zoning_officer.zoning.schedule')->middleware('auth');
    Route::post('/zoning_officer/zoning/{id}/cancel', [OboController::class, 'cancel']);
    Route::post('/zoning_officer/zoning/{id}/reschedule', [OboController::class, 'reschedule'])->name('zoning_officer.zoning.reschedule');
    Route::put('/zoning_visitations/{id}/status', [OboController::class, 'updateStatus'])->name('visitations.updateStatus');

    // Route::put('/visitations/{id}/status', [OboController::class, 'cancel'])->name('schedules.cancel');
});

Route::middleware(['auth', 'verified', 'role:sanitary_officer'])->group(function () {
    Route::get('/sanitary_officer/dashboard', function () {
        return view('sanitary_officer.dashboard');
    })->name('sanitary_officer.dashboard');

    Route::get('/sanitary_officer/sanitary_records', [SanitaryContoller::class, 'sanitary_records'])->name('sanitary_officer.sanitary_records');
    Route::get('/sanitary_officer/sanitary/view_application_data/{id}', [SanitaryContoller::class, 'show_sanitary'])->name('sanitary_officer.sanitary.sanitary_view_record');
    Route::post('/sanitary_officer/sanitary/{id}/approve', [SanitaryContoller::class, 'approve'])->name('sanitary_officer.sanitary.approve');
    Route::post('/sanitary_officer/sanitary/{id}/disapprove', [SanitaryContoller::class, 'disapprove'])->name('sanitary_officer.sanitary.disapprove');
    Route::post('/sanitary_officer/sanitary/{id}/resubmit', [SanitaryContoller::class, 'resubmit'])->name('sanitary_officer.sanitary.resubmit');

    Route::get('/sanitary_officer/sanitary_schedule', [SanitaryContoller::class, 'schedule'])->name('sanitary_officer.sanitary_schedule');
    Route::post('/sanitary_officer/sanitary/{id}/set_schedule', [SanitaryContoller::class, 'scheduleVisit'])->name('sanitary_officer.sanitary.schedule');
    Route::post('/sanitary_officer/sanitary/{id}/reschedule', [SanitaryContoller::class, 'reschedule'])->name('sanitary_officer.sanitary.reschedule');
    Route::put('/visitations/{id}/status', [SanitaryContoller::class, 'updateStatus'])->name('visitations.updateStatus');
});

Route::middleware(['auth', 'verified', 'role:obo'])->group(function () {
    Route::get('/obo/dashboard', function () {
        return view('obo.dashboard');
    })->name('obo.dashboard');
    // Route::get('/sanitary_officer/sanitary_records', [SanitaryContoller::class, 'sanitary_records'])->name('sanitary_officer.sanitary_records');

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

            $user->notify(new PasswordResetSuccess);
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');

Route::get('/zoning_certificate/{id}/verify', [PdfController::class, 'verify'])->name('zoning_certificate.verify');
Route::get('/sanitary_certificate/{id}/verify', [PdfController::class, 'verifySanitary'])->name('sanitary_certificate.verify');
