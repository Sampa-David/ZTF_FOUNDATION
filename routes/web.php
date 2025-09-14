<?php
use App\Http\Kernel;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\TwoFAController;
use App\Http\Controllers\ComiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\HqStaffFormController;
use App\Http\Controllers\FirstRegistrationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoleAssignmentController;


// Route pour afficher le formulaire de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route pour traiter la soumission du formulaire
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::middleware('auth')->group(function() {
    Route::get('/departments/dashboard', function() {
        return view('departments.dashboard');
    })->name('headDept.dashboard');

    Route::get('/staff/dashboard', function() {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    Route::get('/committee/dashboard', [ComiteController::class, 'dashboard'])->name('committee.dashboard');
});

/*Route::middleware(['auth', 'role:super_admin'])->group(function(){
    Route::get('/superAdmin/dashboard',[SuperAdminController::class,'dashboard'])->name('dashboard');
}); 

Route::middleware(['auth', 'role:Admin1|1'])->group(function(){
    Route::get('/committee/dashboard',[ComiteController::class,'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:Admin2|2'])->group(function(){
    Route::get('/departments/dashboard',[DepartmentController::class,'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:staff|3'])->group(function(){
    Route::get('/staff/dashboard',[UserController::class,'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:chef_service|3'])->group(function(){
    Route::get('/staff/dashboard',[UserController::class,'dashboard'])->name('dashboard');
});*/

Route::post('update',[UserController::class,'update'])->name('users.update');
Route::post('destroy',[UserController::class,'destroy'])->middleware('auth')->name('staff.index');



/*Route::get('/staff/dashboard',[UserController::class,'dashboard'])
->middleware('auth')->name('dashboard');*/

Route::get('/staff/index',function(){
    return view('/staff/index');
})->middleware('auth')->name('staff.index');

Route::get('/staff/statistique',function(){
    return view('/staff/statistique');
})->middleware('auth')->name('statistique');

// Route publique pour la vue des départements
//Route::get('/departments', [DepartmentController::class, 'depts'])->name('departments');


Route::middleware('auth')->group(function () {
    Route::post('/roles/store',[RoleController::class,'store'])->name('roles.store');
    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy',
    ]);

    Route::post('permissions/store',[PermissionController::class,'store'])->name('permissions.store');
    Route::resource('permissions', PermissionController::class)->names([
        'index' => 'permissions.index',
        'create' => 'permissions.create',
        'store' => 'permissions.store',
        'show' => 'permissions.show',
        'edit' => 'permissions.edit',
        'update' => 'permissions.update',
        'destroy' => 'permissions.destroy',
    ]);

    // Routes spécifiques des départements (doivent être avant la resource)
    Route::get('/departments/choose', function(){
        return view('departments.choose');
    })->name('departments.choose');
    
    Route::get('/departments/indexDepts',[DepartmentController::class,'indexDepts'])->name('indexDepts');
    Route::get('/departments/dashboard',[DepartmentController::class,'dashboard'])->name('departments.dashboard');

    // Resource routes pour les départements
    Route::resource('departments', DepartmentController::class)->names([
        'index' => 'departments.index',
        'create' => 'departments.create',
        'store' => 'departments.store',
        'show' => 'departments.show',
        'edit' => 'departments.edit',
        'update' => 'departments.update',
        'destroy' => 'departments.destroy',
    ])->except(['show']); // Exclure la route show pour éviter les conflits

    // Routes pour le comité
    Route::resource('committee', ComiteController::class)->names([
        'index' => 'committee.index',
        'create' => 'committee.create',
        'store' => 'committee.store',
        'show' => 'committee.show',
        'edit' => 'committee.edit',
        'update' => 'committee.update',
        'destroy' => 'committee.destroy',
    ]);
    Route::post('/auth/login',[LoginController::class,'login'])->name('staff.store');
    Route::post('departments/Save-Depts',[LoginController::class,'saveDepts'])->name('departments.saveDepts');
    // Toutes les routes de service avec le middleware en utilisant le chemin complet de la classe
    Route::middleware(\App\Http\Middleware\DepartmentAccessMiddleware::class)->group(function () {
        Route::resource('services', ServiceController::class)->names([
            'index' => 'services.index',
            'create' => 'services.create',
            'store' => 'services.store',
            'show' => 'services.show',
            'edit' => 'services.edit',
            'update' => 'services.update',
            'destroy' => 'services.destroy',
        ]);
    });
    Route::get('/superAdmin/dashboard',[SuperAdminController::class,'dashboard'])->name('dashboard');
    
    Route::get('/auth/2fa',function(){
        return view('auth.2fa');
        })->name('twoFactorAuth');
    Route::post('auth/2fa-send',[TwoFAController::class,'sendCode'])->name('sendCode');
    Route::post('/ath/2fa-verify',[TwoFAController::class,'verifyCode'])->name('verifyCode');

});

Route::get('/staff/create',[UserController::class,'create'])->name('staff.create');

// Afficher le formulaire pour un département
Route::get('/departments/{department}/assign', [SuperAdminController::class, 'assign'])
    ->middleware('auth')
    ->name('departments.assign');

// Soumettre le formulaire pour assigner les utilisateurs
Route::put('/departments/{department}/assign-users', [SuperAdminController::class, 'assignUsers'])
    ->middleware('auth')
    ->name('departments.assignUsers');





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
Route::post('/download-pdf', [HqStaffFormController::class, 'telechargerPDF'])->name('download.pdf');
Route::get('/formulaire/create',[HqStaffFormController::class,'showBigForm'])->name('BigForm');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');
    
    // Routes pour la gestion des rôles et permissions par le super admin
    Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
        Route::get('/role-assignments', [RoleAssignmentController::class, 'index'])->name('role.assignments');
        Route::post('/assign-role', [RoleAssignmentController::class, 'assignRole'])->name('assign.role');
        Route::post('/assign-permission', [RoleAssignmentController::class, 'assignPermission'])->name('assign.permission');
        Route::get('/get-user-roles-permissions/{userId}', [RoleAssignmentController::class, 'getUserRolesAndPermissions']);
    });

    // Routes pour le formulaire complet d'inscription
    Route::get('/complete-registration', [UserController::class, 'create'])->name('registration.create');
    Route::post('/complete-registration', [UserController::class, 'store'])->name('registration.store');
    Route::post('/auth/register', [UserController::class, 'finalRegister'])->name('auth.register.submit');

    // Routes du profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

});




// The route for your home page, with a name
Route::get('/', function () {
    return view('home');
})->name('home');



Route::get('/check-registration-status', [App\Http\Controllers\Auth\UserStatusController::class, 'checkRegistrationStatus'])
    ->name('check.registration.status');

/*Route::middleware(['auth'])->group(function () {
    // Super Admin Routes
    Route::group(['middleware' => ['superadmin'], 'prefix' => 'superadmin', 'as' => 'superadmin.'], function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
});
});*/
