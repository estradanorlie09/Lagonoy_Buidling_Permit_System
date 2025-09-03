<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ApplicantController;

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
Route::middleware(['auth', 'role:applicant'])->group(function () {
    Route::get('/applicant/dashboard', function () {
        return view('applicant.dashboard');
    })->name('applicant.dashboard');

    Route::get('/applicant/records', [ApplicantController::class, 'records'])->name('applicant.records');
    Route::get('/applicant/form', [ApplicantController::class, 'form'])->name('applicant.forms.form');
    Route::get('/applicant/zoning_form', [ApplicantController::class, 'zoning_form'])->name('applicant.forms.zoning.zoning_form');
    Route::get('/applicant/schedule', [ApplicantController::class, 'schedule'])->name('applicant.calendar.schedule');
    Route::get('/applicant/setting', [ApplicantController::class, 'setting'])->name('applicant.setting');
    Route::get('/applicant/permit', [ApplicantController::class, 'permit'])->name('applicant.permit');

    Route::get('/applicant/update_profile', [ApplicantController::class, 'update_profile'])->name('applicant.forms.profile.update_form');
    Route::post('/update_user', [FormController::class, 'update_user_profile'])->name('update_user_profile');
    Route::post('/location/municipalities', [ApplicantController::class, 'getMunicipalities']);
    Route::post('/location/barangays', [ApplicantController::class, 'getBarangays']);
});

// OBO
Route::middleware(['auth', 'role:obo'])->group(function () {
    Route::get('/obo/dashboard', function () {
        return view('obo.dashboard');
    })->name('obo.dashboard');
});

// logout
Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'admin_dashboard']);

// locations
