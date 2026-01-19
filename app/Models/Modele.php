<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    protected $table = 'modele';
    protected $primaryKey = 'id_modele';
    public $timestamps = false;

    protected $fillable = [
        'id_marque',
        'libelle',
        'type_vehicule',
        'url_img',
        'actif',
    ];

    public function marque()
    {
        return $this->belongsTo(Marque::class, 'id_marque', 'id_marque');
    }

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class, 'id_modele', 'id_modele');
    }
}
