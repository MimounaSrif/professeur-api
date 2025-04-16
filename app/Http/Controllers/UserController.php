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

        // Comparaison insensible à la casse
        if (strtolower($user->course) !== strtolower($id)) {
            return response()->json(['error' => 'Vous n\'avez pas accès à ce cours.'], 403);
        }

        // Liste de cours fictive (tu peux remplacer par une table plus tard)
        $courses = [
            'français' => [
                'title' => 'Cours de Français',
                'description' => 'Apprenez la grammaire, la conjugaison et le vocabulaire français.',
                'instructor' => '....',
                'lessons' => [
                    ['title' => 'Introduction au français'],
                    ['title' => 'Grammaire de base'],
                    ['title' => 'Exercices pratiques']
                ]
            ],
            'anglais' => [
                'title' => 'Cours d’Anglais',
                'description' => 'Improve your grammar, vocabulary, and conversation in English.',
                'instructor' => '....',
                'lessons' => [
                    ['title' => 'English Basics'],
                    ['title' => 'Simple Present'],
                    ['title' => 'Speaking Practice']
                ]
            ],
            'allemand' => [
                'title' => 'Kurs Deutsch',
                'description' => 'Lernen Sie die Grundlagen der deutschen Sprache.',
                'instructor' => '....',
                'lessons' => [
                    ['title' => 'Deutsche Einführung'],
                    ['title' => 'Verben und Artikel'],
                    ['title' => 'Dialogübungen']
                ]
            ],
        ];

        $courseKey = strtolower($id);

        if (!isset($courses[$courseKey])) {
            return response()->json(['error' => 'Cours non trouvé.'], 404);
        }

        return response()->json([
            'id' => $id,
            'title' => $courses[$courseKey]['title'],
            'description' => $courses[$courseKey]['description'],
            'instructor' => $courses[$courseKey]['instructor'],
            'lessons' => $courses[$courseKey]['lessons'],
            'created_at' => $user->created_at
        ]);
    }
}
