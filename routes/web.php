<?php

use App\Http\Middleware\SuperAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ComiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\HqStaffFormController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FirstRegistrationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.store');

/* Route::middleware(['auth','role:super_admin'])->group(function(){
Route::get('/superAdmin/dashboard',[SuperAdminController::class,'dashboard'])->name('dashboard');
}); */

/*Route::middleware(['auth','role:Admin1,1'])->group(function(){
    Route::get('/committee/dashboard',[ComiteController::class,'dashboard'])->name('dashboard');
});

Route::middleware(['auth','role:Admin2,2'])->group(function(){
    Route::get('/departments/dashboard',[DepartmentController::class,'dashboard'])->name('dashboard');
});

Route::middleware(['auth','role:staff,3'])->group(function(){
    Route::get('/staff/dashboard',[StaffController::class,'dashboard'])->name('dashboard');
});

Route::middleware(['auth','role:chef_service,3'])->group(function(){
    Route::get('/staff/dashboard',[StafffController::class,'dashboard'])->name('dashboard');
});*/

Route::post('update',[UserController::class,'update'])->name('users.update');
Route::post('destroy',[UserController::class,'destroy'])->middleware('auth')->name('staff.index');
Route::get('/superAdmin/dashboard',[SuperAdminController::class,'dashboard'])
->middleware('auth')->name('dashboard');
/*Route::get('/staff/dashboard',[UserController::class,'dashboard'])
->middleware('auth')->name('dashboard');*/

Route::get('/staff/index',function(){
    return view('/staff/index');
})->middleware('auth')->name('index');

Route::get('/staff/statistique',function(){
    return view('/staff/statistique');
})->middleware('auth')->name('statistique');

// Routes pour les départements
Route::middleware('auth')->group(function () {
    Route::resource('departments', DepartmentController::class)->names([
        'index' => 'departments.index',
        'create' => 'departments.create',
        'store' => 'departments.store',
        'show' => 'departments.show',
        'edit' => 'departments.edit',
        'update' => 'departments.update',
        'destroy' => 'departments.destroy',
    ]);
});

Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy',
    ]);
});

Route::get('/staff/statistiques', [App\Http\Controllers\StatistiqueController::class, 'index'])
    ->middleware('auth')->name('statistiques');
Route::get('/api/statistics', [App\Http\Controllers\StatistiqueController::class, 'apiStats'])
    ->middleware('auth');

// Authentication Routes
Route::middleware('guest')->group(function () {

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
    Route::post('/identification/form',[FirstRegistrationController::class,'register'])->name('identification.register');
    Route::get('/identification/identification-after-registration', [FirstRegistrationController::class, 'showIdentification'])
        ->name('identification.identification_after_registration');
    Route::post('/verify-identification', [FirstRegistrationController::class, 'verifyIdentification'])
        ->name('verify.identification');
    Route::post('/resend-identification-code', [FirstRegistrationController::class, 'resendCode'])
        ->name('resend.code');
    Route::get('/code-expired', [FirstRegistrationController::class, 'codeExpired'])
        ->name('code.expired');
});

//Pour les Fichier Pdf
Route::post('/download-pdf', [HqStaffFormController::class, 'DownloadPdf'])->name('download.pdf');
Route::get('/formulaire/create',[HqStaffFormController::class,'showBigForm'])->name('BigForm');

Route::middleware('auth')->group(function () {
    Route::post('logout', [ProfileController::class, 'destroy'])
        ->name('logout');
    
    // Routes pour le formulaire complet d'inscription
    Route::get('/complete-registration', [UserController::class, 'create'])->name('registration.create');
    Route::post('/complete-registration', [UserController::class, 'store'])->name('registration.store');
    Route::post('/auth/register', [UserController::class, 'finalRegister'])->name('auth.register.submit');

    // Routes du profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// The route for your home page, with a name
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes for other pages, all with unique names
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::middleware(['auth'])->group(function () {
    // Super Admin Routes
    Route::group(['middleware' => ['superadmin'], 'prefix' => 'superadmin', 'as' => 'superadmin.'], function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    });
});
