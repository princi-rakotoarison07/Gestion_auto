<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Vehicule;
use App\Models\Client;
use App\Models\Employe;
use App\Models\StatutPaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VenteController extends Controller
{
    public function index()
    {
        $ventes = DB::table('vente')
            ->join('vehicule', 'vente.id_vehicule', '=', 'vehicule.id_vehicule')
            ->join('modele', 'vehicule.id_modele', '=', 'modele.id_modele')
            ->join('marque', 'modele.id_marque', '=', 'marque.id_marque')
            ->join('client', 'vente.id_client', '=', 'client.id_client')
            ->join('statut_paiement', 'vente.id_statut_paiement', '=', 'statut_paiement.id_statut_paiement')
            ->select(
                'vente.*',
                'marque.libelle as marque_nom',
                'modele.libelle as modele_libelle',
                'vehicule.immatriculation',
                'client.nom as client_nom',
                'client.prenom as client_prenom',
                'statut_paiement.libelle as statut_libelle'
            )
            ->orderByDesc('vente.date_vente')
            ->get();

        return view('ventes.index', compact('ventes'));
    }

    public function create()
    {
        // On ne prend que les véhicules qui ne sont pas encore vendus
        $vehiculesVendues = Vente::pluck('id_vehicule')->toArray();
        $vehicules = DB::table('vehicule')
            ->join('modele', 'vehicule.id_modele', '=', 'modele.id_modele')
            ->join('marque', 'modele.id_marque', '=', 'marque.id_marque')
            ->whereNotIn('vehicule.id_vehicule', $vehiculesVendues)
            ->select('vehicule.*', 'marque.libelle as marque_nom', 'modele.libelle as modele_libelle')
            ->get();

        $clients = Client::orderBy('nom')->get();
        $employes = Employe::all();
        $statuts = StatutPaiement::all();

        return view('ventes.create', compact('vehicules', 'clients', 'employes', 'statuts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_vente' => ['required', 'date'],
            'id_vehicule' => ['required', 'exists:vehicule,id_vehicule', 'unique:vente,id_vehicule'],
            'id_client' => ['required', 'exists:client,id_client'],
            'id_employe' => ['required', 'exists:employe,id_employe'],
            'montant_total' => ['required', 'numeric', 'min:0'],
            'id_statut_paiement' => ['required', 'exists:statut_paiement,id_statut_paiement'],
            'date_paiement_complet' => ['nullable', 'date', 'after_or_equal:date_vente'],
        ], [
            'id_vehicule.unique' => 'Ce véhicule a déjà été vendu.',
            'date_vente.required' => 'La date de vente est obligatoire.',
            'id_client.required' => 'Le client est obligatoire.',
            'id_employe.required' => 'L\'employé est obligatoire.',
            'montant_total.required' => 'Le montant total est obligatoire.',
            'id_statut_paiement.required' => 'Le statut de paiement est obligatoire.',
        ]);

        Vente::create($validated);

        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée avec succès.');
    }

    public function storeClientAjax(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'telephone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'telephone.required' => 'Le téléphone est obligatoire.',
            'email.email' => 'L\'adresse email est invalide.',
        ]);

        $client = Client::create($validated);

        return response()->json([
            'success' => true,
            'client' => $client
        ]);
    }
}
