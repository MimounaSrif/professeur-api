<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPublicationController;

// ✅ Authentification (publique)
Route::post('/admin-login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/user-login', [AuthController::class, 'userLogin']);

// ✅ Routes accessibles après connexion (auth:api)
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/user-profile', function (\Illuminate\Http\Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });

    Route::get('/user/courses/{id}', [UserController::class, 'courseDetail']);
});

// ✅ Routes admin protégées (auth:api + is_admin)
Route::middleware(['auth:api', 'is_admin'])->group(function () {
    // Tableau de bord admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    // Gestion des utilisateurs
    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::put('/admin/users/{id}/accept', [AdminUserController::class, 'accept']);
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy']);

    // Gestion des publications
    Route::get('/admin/publications', [AdminPublicationController::class, 'index']);
    Route::put('/admin/publications/{id}/archive', [AdminPublicationController::class, 'archive']);
});
