<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPublicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;


// Auth publiques
Route::post('/admin-login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/user-login', [AuthController::class, 'userLogin']);

// Routes accessibles aux utilisateurs connectés (token JWT requis)
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']
);
    Route::get('/user-profile', fn(\Illuminate\Http\Request $request) => response()->json(['user' => $request->user()]));
    Route::get('/user/courses/{id}', [UserController::class, 'courseDetail']);
});

// Routes Admin protégées (authentification + rôle admin)
    Route::middleware(['auth:api', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    
    // Publications admin
    Route::get('/admin/publications', [AdminPublicationController::class, 'index']);
    Route::post('/admin/publications', [AdminPublicationController::class, 'store']);
    Route::put('/admin/publications/{id}/archive', [AdminPublicationController::class, 'archive']);
    Route::delete('/admin/publications/{id}', [AdminPublicationController::class, 'destroy']);

    //  Utilisateurs
    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::put('/admin/users/{id}/accept', [AdminUserController::class, 'accept']);
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy']);

});

//  Route publique pour la page d'accueil
Route::get('/publications', [AdminPublicationController::class, 'public']);
