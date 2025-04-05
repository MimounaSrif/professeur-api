<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; // 👈 à ajouter
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject // 👈 implements ajouté
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'cin',
        'phone',
        'course',
        'role',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔽 Ces deux méthodes sont obligatoires pour JWTAuth
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
