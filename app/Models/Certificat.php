<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    //
    protected $fillable = [
        'date_certificat',
        'habitant_id',
        'statut',
        'transaction_id',
    ];

    protected $casts = [
        'date_certificat' => 'date',
    ];

    public function habitant()
    {
        return $this->belongsTo(Habitant::class);
    }
}
