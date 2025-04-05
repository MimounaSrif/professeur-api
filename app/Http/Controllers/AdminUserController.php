<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // 🔹 Récupérer tous les utilisateurs avec rôle = user
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return response()->json(['users' => $users]);
    }

    // 🔹 Accepter un utilisateur
    public function accept($id)
    {
        $user = User::findOrFail($id);
        $user->accepted = true;
        $user->save();

        return response()->json(['message' => 'Utilisateur accepté avec succès']);
    }

    // 🔹 Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
