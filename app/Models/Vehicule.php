<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $table = 'vehicule';
    protected $primaryKey = 'id_vehicule';
    public $timestamps = false;

    protected $fillable = [
        'id_modele',
        'id_couleur',
        'id_statut_vehicule',
        'nombre_stock',
        'immatriculation',
        'annee',
        'kilometrage',
        'numero_chassis',
        'img_vehicule',
        'prix_achat',
        'prix_vente',
        'date_acquisition',
    ];

    public function modele()
    {
        return $this->belongsTo(Modele::class, 'id_modele', 'id_modele');
    }
}
