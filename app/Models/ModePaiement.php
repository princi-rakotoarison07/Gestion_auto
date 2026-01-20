<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModePaiement extends Model
{
    protected $table = 'mode_paiement';
    protected $primaryKey = 'id_mode_paiement';
    public $timestamps = false;

    protected $fillable = [
        'libelle',
        'actif',
    ];

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_mode_paiement', 'id_mode_paiement');
    }
}
