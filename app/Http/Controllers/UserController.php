<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Détails d’un cours spécifique auquel l’utilisateur est inscrit
     */
    public function courseDetail($id)
    {
        $user = Auth::user();

        // Option : vérifier si l’utilisateur a accès à ce cours (si cours assigné)
        if ($user->course !== $id) {
            return response()->json(['error' => 'Vous n\'avez pas accès à ce cours.'], 403);
        }

        // Exemple de données fictives du cours (à remplacer par une table 'courses' si tu veux plus tard)
        $courses = [
            'français' => [
                'title' => 'Cours de Français',
                'description' => 'Apprenez la grammaire, la conjugaison et le vocabulaire français.',
            ],
            'anglais' => [
                'title' => 'Cours d’Anglais',
                'description' => 'Improve your grammar, vocabulary, and conversation in English.',
            ],
            'allemand' => [
                'title' => 'Kurs Deutsch',
                'description' => 'Lernen Sie die Grundlagen der deutschen Sprache.',
            ],
        ];

        $courseKey = strtolower($id);

        if (!isset($courses[$courseKey])) {
            return response()->json(['error' => 'Cours non trouvé.'], 404);
        }

        return response()->json([
            'course' => $courses[$courseKey],
            'user' => $user
        ]);
    }
}
