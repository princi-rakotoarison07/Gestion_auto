<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Vente;
use App\Models\ModePaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    public function index()
    {
        // On récupère les paiements groupés par vente et par date
        $paiementsGroupes = Paiement::with(['vente.client', 'vente.vehicule.modele.marque', 'modePaiement'])
            ->select('id_vente', 'date_paiement', DB::raw('SUM(montant) as total_journalier'))
            ->groupBy('id_vente', 'date_paiement')
            ->orderByDesc('date_paiement')
            ->get();

        return view('paiements.index', compact('paiementsGroupes'));
    }

    public function create()
    {
        // On ne prend que les ventes qui ne sont pas encore totalement payées
        $ventes = Vente::with(['client', 'vehicule.modele.marque'])
            ->where('id_statut_paiement', '!=', 3) // 3 = complet (selon StatutPaiementSeeder)
            ->get();
            
        $modes = ModePaiement::where('actif', true)->get();

        return view('paiements.create', compact('ventes', 'modes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_vente' => 'required|exists:vente,id_vente',
            'date_paiement' => 'required|date',
            'paiements' => 'required|array|min:1',
            'paiements.*.id_mode_paiement' => 'required|exists:mode_paiement,id_mode_paiement',
            'paiements.*.montant' => 'required|numeric|min:0.01',
            'paiements.*.reference' => 'nullable|string|max:100',
        ], [
            'paiements.required' => 'Au moins un mode de paiement est requis.',
            'paiements.*.montant.min' => 'Le montant doit être supérieur à 0.',
        ]);

        $vente = Vente::findOrFail($request->id_vente);
        $totalAPayer = $vente->reste_a_payer;
        $totalSaisi = collect($request->paiements)->sum('montant');

        if ($totalSaisi > $totalAPayer + 0.01) { // Marge d'erreur de calcul decimal
            return back()->withErrors(['paiements' => 'Le montant total saisi (' . $totalSaisi . ') dépasse le reste à payer (' . $totalAPayer . ').'])->withInput();
        }

        DB::transaction(function () use ($request, $vente, $totalSaisi) {
            foreach ($request->paiements as $p) {
                Paiement::create([
                    'id_vente' => $request->id_vente,
                    'id_mode_paiement' => $p['id_mode_paiement'],
                    'date_paiement' => $request->date_paiement,
                    'montant' => $p['montant'],
                    'reference' => $p['reference'] ?? null,
                ]);
            }

            // Mettre à jour le statut de la vente
            $nouveauMontantPaye = $vente->montant_paye + $totalSaisi;
            
            if ($nouveauMontantPaye >= $vente->montant_total - 0.01) {
                $vente->id_statut_paiement = 3; // Complet
                $vente->date_paiement_complet = $request->date_paiement;
            } else {
                $vente->id_statut_paiement = 2; // Partiel
            }
            $vente->save();
        });

        return redirect()->route('paiements.index')->with('success', 'Paiement(s) enregistré(s) avec succès.');
    }

    public function getVenteDetailsAjax($id)
    {
        $vente = Vente::with(['client', 'vehicule.modele.marque'])->find($id);
        
        if (!$vente) {
            return response()->json(['success' => false, 'message' => 'Vente non trouvée'], 404);
        }

        return response()->json([
            'success' => true,
            'montant_total' => $vente->montant_total,
            'montant_paye' => $vente->montant_paye,
            'reste_a_payer' => $vente->reste_a_payer,
            'client' => $vente->client->nom . ' ' . $vente->client->prenom,
            'vehicule' => $vente->vehicule->modele->marque->libelle . ' ' . $vente->vehicule->modele->libelle
        ]);
    }
}
