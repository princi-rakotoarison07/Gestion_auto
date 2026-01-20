<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'id_client';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
    ];

    public function ventes()
    {
        return $this->hasMany(Vente::class, 'id_client', 'id_client');
    }
}
