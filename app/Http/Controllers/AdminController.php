<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'message' => 'Bienvenue sur le tableau de bord Admin 👋'
        ]);
    }
}
