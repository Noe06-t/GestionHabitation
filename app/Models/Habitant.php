<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitant extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_naissance',
        'quartier',
    ];

    public function certificats()
    {
        return $this->hasMany(Certificat::class);
    }
}
