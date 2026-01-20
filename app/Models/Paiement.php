<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiement';
    protected $primaryKey = 'id_paiement';
    public $timestamps = false;

    protected $fillable = [
        'id_vente',
        'id_mode_paiement',
        'date_paiement',
        'montant',
        'reference',
    ];

    public function vente()
    {
        return $this->belongsTo(Vente::class, 'id_vente', 'id_vente');
    }

    public function modePaiement()
    {
        return $this->belongsTo(ModePaiement::class, 'id_mode_paiement', 'id_mode_paiement');
    }
}
