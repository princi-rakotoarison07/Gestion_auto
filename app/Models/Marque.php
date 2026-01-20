<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    protected $table = 'marque';
    protected $primaryKey = 'id_marque';
    public $timestamps = false;

    protected $fillable = [
        'libelle',
        'pays_origine',
        'actif',
    ];

    public function modeles()
    {
        return $this->hasMany(Modele::class, 'id_marque', 'id_marque');
    }
}
