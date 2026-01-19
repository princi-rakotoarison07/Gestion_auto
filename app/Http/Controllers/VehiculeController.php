<?php

namespace App\Http\Controllers;

use App\Models\Modele;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = Vehicule::query()
            ->with(['modele.marque'])
            ->orderByDesc('id_vehicule')
            ->get();

        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        $modeles = Modele::query()
            ->with('marque')
            ->orderBy('id_marque')
            ->orderBy('libelle')
            ->get();

        return view('vehicules.create', compact('modeles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_modele' => ['required', 'integer', 'exists:modele,id_modele'],
            'immatriculation' => ['nullable', 'string', 'max:20', 'unique:vehicule,immatriculation'],
            'annee' => ['required', 'integer', 'min:1900', 'max:' . (now()->year + 1)],
            'couleur' => ['nullable', 'string', 'max:30'],
            'kilometrage' => ['nullable', 'integer', 'min:0'],
            'numero_chassis' => ['nullable', 'string', 'max:50', 'unique:vehicule,numero_chassis'],
            'prix_achat' => ['required', 'numeric', 'min:0'],
            'prix_vente' => ['required', 'numeric', 'min:0'],
            'statut' => ['required', 'in:en_stock,vendu,en_reparation,reserve'],
            'date_acquisition' => ['required', 'date'],
        ]);

        Vehicule::create($validated);

        return redirect('/vehicules');
    }
}
