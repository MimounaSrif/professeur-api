<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Connexion de l'administrateur avec JWT
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Tentative de connexion
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email ou mot de passe invalide'], 401);
        }

        // Récupérer l'utilisateur connecté
        $user = Auth::guard('api')->user();

        // Vérifier le rôle admin
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Inscription d'un utilisateur standard
     */
    public function register(Request $request)
{
    // Validation des champs
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users',
        'password'   => 'required|string|min:8',
        'cin'        => 'required|string|max:20',
        'phone'      => 'required|string|max:20',
        'course'     => 'required|string',
    ]);

    // Hachage du mot de passe
    $validated['password'] = Hash::make($validated['password']);
    $validated['role'] = 'user';

    // Création de l'utilisateur
    $user = User::create($validated);

    // ✅ Génération du token JWT
    $token = auth('api')->login($user);

    // ✅ Réponse avec token + infos user
    return response()->json([
        'message' => 'Utilisateur inscrit avec succès',
        'user'    => $user,
        'token'   => $token
    ], 201);
}

    /**
 * Connexion d’un utilisateur standard
 */
public function userLogin(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (!$token = Auth::guard('api')->attempt($credentials)) {
        return response()->json(['error' => 'Email ou mot de passe invalide'], 401);
    }

    $user = Auth::guard('api')->user();

    // Vérifie que ce n’est pas un admin
    if ($user->role !== 'user') {
        return response()->json(['error' => 'Accès réservé aux utilisateurs'], 403);
    }

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}
public function me(Request $request)
{
    $user = Auth::guard('api')->user();

    return response()->json([
        'user' => $user
    ]);
}
}
