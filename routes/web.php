<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HqStaffFormController;
use App\Http\Controllers\FirstRegistrationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::get('/profile/edit',[UserController::class,'edit'])->name('profile.edit');
// Authentication Routes
Route::middleware('guest')->group(function () {
    // Routes d'authentification
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');
    Route::get('login',[LoginController::class,'showLoginForm'])->name('login');
    Route::get('/register',[UserController::class,'showRegistrationForm'])->name('auth.register');
    Route::post('login-connect',[LoginController::class,'login'])->name('auth.login');

    //Pour les Fichier Pdf
    Route::post('/telecharger-pdf', [App\Http\Controllers\HqStaffFormController::class, 'DownloadPdf'])->name('telechargerPdf');
    Route::get('/formulaire/create',[HqStaffFormController::class,'showBigForm'])->name('BigForm');

    // Routes pour la réinitialisation du mot de passe
    Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
        ->name('password.update');
    
    // Routes pour la vérification d'identite
    Route::get('/identification/form', [FirstRegistrationController::class, 'showRegistrationForm'])
        ->name('identification.form');
    Route::post('/identification/form',[FirstRegistrationController::class,'register'])->name('register');
    Route::get('/identification/identification-after-registration', [FirstRegistrationController::class, 'showIdentification'])
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
    
    // Routes pour le formulaire complet d'inscription
    Route::get('/complete-registration', [UserController::class, 'create'])->name('users.create');
    Route::post('/complete-registration', [UserController::class, 'store'])->name('users.store');
    Route::post('/auth/register', [UserController::class, 'finalRegister'])->name('auth.register.submit');
});

Route::get('/profile/edit',function(){
    return view('profile.edit');
})->middleware('auth')->name('profile.edit');

Route::put('/profile/update-profile-information-form',[UserController::class,'update'])->name('profile.update');
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



