<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Autres méthodes et attributs...

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isResponsable()
    {
        return $this->role === 'responsable';
    }

    public function isRH()
    {
        return $this->role === 'rh';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}
