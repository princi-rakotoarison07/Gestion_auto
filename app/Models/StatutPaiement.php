<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatutPaiement extends Model
{
    protected $table = 'statut_paiement';
    protected $primaryKey = 'id_statut_paiement';
    public $timestamps = false;

    protected $fillable = [
        'libelle',
        'actif',
    ];
}
