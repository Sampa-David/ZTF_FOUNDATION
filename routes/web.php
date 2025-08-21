<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FirstRegistrationController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Routes d'authentification standard
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Routes pour l'inscription
    Route::get('/form', [FirstRegistrationController::class, 'showRegistrationForm'])
        ->name('identification.form');
    Route::post('/register', [FirstRegistrationController::class, 'register'])
        ->name('first.register');

    // Routes pour l'inscription et  la vérification d'identité
    Route::get('/identification/form',[FirstRegistrationController::class,'showRegistrationForm'])->name('identification.form');
    Route::get('/identification-after-registration', [FirstRegistrationController::class, 'showIdentification'])
        ->name('identification.identification_after_registration');
    Route::post('/verify-identification', [FirstRegistrationController::class, 'verifyIdentification'])
        ->name('verify.identification');
    Route::post('/resend-identification-code', [FirstRegistrationController::class, 'resendCode'])
        ->name('resend.code');
    Route::get('/code-expired', [FirstRegistrationController::class, 'codeExpired'])
        ->name('code.expired');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// The route for your home page, with a name
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes for other pages, all with unique names
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/departments', function () {
    return view('departments');
})->name('departments');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');



