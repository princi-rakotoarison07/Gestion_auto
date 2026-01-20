<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $table = 'vente';
    protected $primaryKey = 'id_vente';
    public $timestamps = false;

    protected $fillable = [
        'date_vente',
        'id_vehicule',
        'id_client',
        'id_employe',
        'montant_total',
        'id_statut_paiement',
        'date_paiement_complet',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'id_vehicule', 'id_vehicule');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id_client');
    }

    public function statutPaiement()
    {
        return $this->belongsTo(StatutPaiement::class, 'id_statut_paiement', 'id_statut_paiement');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_vente', 'id_vente');
    }

    public function getMontantPayeAttribute()
    {
        return $this->paiements()->sum('montant');
    }

    public function getResteAPayerAttribute()
    {
        return $this->montant_total - $this->montant_paye;
    }
}
