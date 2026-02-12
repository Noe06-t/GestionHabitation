<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Habitant extends Authenticatable
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'date_naissance',
        'quartier',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'date_naissance' => 'date',
        ];
    }

    public function certificats()
    {
        return $this->hasMany(Certificat::class);
    }
}
